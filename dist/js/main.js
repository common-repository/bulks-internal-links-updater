jQuery(document).ready(function ($) {
    // Tab
    $(".nav-link").on("click", function() {
        $(".nav-link").removeClass("active");
        $(this).addClass("active");
        
        // Hide all tab pane
        $(".tab-content .tab-pane").removeClass("active");
        $(`.tab-content .tab-pane${$(this).attr("data-target")}`).addClass("active")
    })

    // Post select2 lists
    $("#posts").select2({
        minimumInputLength: 3,
        ajax: {
            url: $("#ajax_url").val(),
            type: "GET",
            dataType: 'json',
            data: function (params) {
              var query = {
                action: "mbulet_ilu_get_posts",
                search: params.term,
                type: 'public'
              }
              return query;
            },
            processResults: function (response) {
                return {
                    results: response
                };
            }
        }
    }).on("select2:select", async function(e) {
        $(".loader-wrapper").css("display", "flex");
        var data = e.params.data;
        await $.ajax({
            type: "GET",
            url: $("#ajax_url").val(),
            data: {
                action: "mbulet_ilu_get_post",
                post_id: data.id
            },
            dataType: "json",
            success: async function (response) {
                await $(".tab-pane .update_manual_content").html(response.post_content);
                var internal_links = $(".tab-pane .update_manual_content").children().find("a");
                var data = await []
                for (let i = 0; i < internal_links.length; i++) {
                    const element = internal_links[i];
                    await data.push({
                        id: $(element).attr("href"),
                        text: $(element).text()
                    })
                }
                $("#post_internal_links").select2({
                    data: data
                })
            }
        });
        $(".loader-wrapper").css("display", "none");
    });

    // Handle manual update
    $("#update_manual").on("click", async function() {
        $(".loader-wrapper").css("display", "flex");
        var form = $("form.update-manual-form");
        var target_link = $(form).find("#post_internal_links").val();
        var replacement_text = $(form).find("#replacement_text").val();
        var replacement_hyperlink = $(form).find("#replacement_hyperlink").val();
        var target = $(".tab-pane .update_manual_content").children().find(`a[href='${target_link}']`);
        
        if( isNotEmpty(replacement_text) ) {
            if( $(target).html().includes("strong") === true ) {
                $(target).html(`<strong>${replacement_text}</strong>`)
            }
            else {
                $(target).html(replacement_text)
            }
        }
        
        $(target).attr("href", replacement_hyperlink)
        
        await updatePost({ 
            post_id: $(form).find("#posts").val(),
            post_content: $(".tab-pane .update_manual_content").html()
        }, true);
    })

    // On input file changes
    $(".update-excel-form #posts").on("change", function(e) {
        $(".update-excel-form #posts_file_name").text(`File selected : ${e.target.files[0].name}`)
    })

    // Update excel
    $("#update_excel").on("click", function() {
        var file = $(".update-excel-form #posts");
        var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.xlsx|.xls)$/;  
        if (regex.test($(".update-excel-form #posts").val().toLowerCase())) {  
            if (typeof (FileReader) != "undefined") {
                var fr = new FileReader()
                var data = $(file)[0].files[0]
        
                fr.onload = getTableData;                                            
                async function getTableData(evt) { 
                    var xlsxflag = false; 
                    if ($(file).val().toLowerCase().indexOf(".xlsx") > 0) {  
                        xlsxflag = true;  
                    }  

                    var data = evt.target.result;
                    if (xlsxflag) {  
                        var workbook = XLSX.read(data, { type: 'binary' });  
                    }  
                    else {  
                        var workbook = XLS.read(data, { type: 'binary' });  
                    }  
            
                    var sheet_name_list = workbook.SheetNames;  
                    
                    var cnt = 0
                    var results = [];
                    await sheet_name_list.forEach( async function (y) { 
                        if (xlsxflag) {  
                            var exceljson = XLSX.utils.sheet_to_json(workbook.Sheets[y]);  
                        }  
                        else {  
                            var exceljson = XLS.utils.sheet_to_row_object_array(workbook.Sheets[y]);  
                        }  
                        if (exceljson.length > 0 && cnt == 0) {  
                            var items = await getTableCell(exceljson);
                            if(items) { // Add data only on valid
                                results.push({
                                    sheet_name: y,
                                    items
                                });  
                            }
                            cnt++;  
                        }
                    });
                    if(results.length > 0) { // Run update only on valid
                        handleUpdateExcel(results);
                    }
                };
                fr.readAsBinaryString(data)                                      
            }  
            else {  
                response['success'] = false
                response['message'] = "Sorry! Your browser does not support HTML5!"
            }   
        }  
        else {  
            alert("Please upload a valid Excel file!");  
        }  
    })

    handleUpdateExcel = async (data) => {
        $(".loader-wrapper").css("display", "flex");
        for (let ir = 0; ir < data.length; ir++) {
            for (let iitem = 0; iitem < data[ir].items.length; iitem++) {
                var element = data[ir].items[iitem]
                await $.ajax({
                    type: "GET",
                    url: $("#ajax_url").val(),
                    data: {
                        action: "mbulet_ilu_get_post",
                        post_id: element.post_id
                    },
                    dataType: "json",
                    success: async function (response) {
                        await $(".tab-pane .update_excel_content").html(response.post_content);
                        var internal_links = $(".tab-pane .update_excel_content").children().find("a");
                        for (let i = 0; i < element.items.length; i++) {
                            for (let il = 0; il < internal_links.length; il++) {
                                const internal_element = element.items[i];
                                const internal_link = internal_links[il];
                                
                                if( untrailingSlash($(internal_link).attr("href")) === untrailingSlash(internal_element.hyperlink) ) {
                                    var is_last = (ir === (data.length - 1) ) && ( iitem ===  (data[ir].items.length - 1) ) 
                                    if( isNotEmpty(internal_element.replacement_text) ) {
                                        if( $(internal_link).html().includes("strong") === true ) {
                                            $(internal_link).html(`<strong>${internal_element.replacement_text}</strong>`)
                                        }
                                        else {
                                            $(internal_link).html(internal_element.replacement_text)
                                        }
                                    }
                                    $(internal_link).attr("href", internal_element.replacement_hyperlink)
                                    await updatePost({ 
                                        post_id: element.post_id,
                                        post_content: $(".tab-pane .update_excel_content").html()
                                    }, is_last);
                                }
                            }
                        }
                        $(".tab-pane .update_excel_content").html("");
                    },
                    error: (request, status, error) => {
                        toast("Error", request.responseJSON.data.message, "error");
                        $(".loader-wrapper").css("display", "none");
                    }
                });        
            }
        }
    }
    
});