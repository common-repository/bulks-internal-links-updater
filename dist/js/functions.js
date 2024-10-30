jQuery(document).ready(function($) {
    
    isNotEmpty = (param) => {
        if(typeof(param) !== "undefined" && param !== null) {
            if(typeof(param) === "string") {
                if(param.length > 0) {
                    return true;
                }
            }
            else if(typeof(param) === "boolean") {
                return true;
            }
            else if(typeof(param) === "object") {
                return true;
            }
        }
        else if(typeof(param) === "boolean") {
            return true;
        }
        return false;
    }

    untrailingSlash = (url) => {     
        return url.replace(/\/$/, "");
    } 

    updatePost = (args, is_last=true) => {
        $.ajax({
            type: "POST",
            url: $("#ajax_url").val(),
            data: {
                action: "mbulet_ilu_update_post",
                ...args
            },
            dataType: "json",
            success: async function (response) {
                var type = response.success ? "success" : "error";

                if(is_last) {
                    $.Toast("Information", response.message, type, {
                        has_icon:true,
                        has_close_btn:true,
                        stack: true,
                        fullscreen: false,
                        timeout: 5000,
                        sticky: false,
                        has_progress: true,
                        rtl: false,
                        position_class: "toast-top-right"
                    });
                    $(".loader-wrapper").css("display", "none");
                    
                    if(response.success) {
                        location.reload();
                    }
                }
            }
        });
    }

    getTableCell = (jsondata) => {
        var columns = getTableColumns(jsondata);
        var data = [];
        for (var i = 0; i < jsondata.length; i++) {  
            var item = {}
            for (var colIndex = 0; colIndex < columns.length; colIndex++) {  
                var cellValue = jsondata[i][columns[colIndex]];  
                if (cellValue == null)  
                    cellValue = "";  
                    if( 
                       (columns[colIndex].toLowerCase().split(" ").join("_") === "hyperlink" || columns[colIndex].toLowerCase().split(" ").join("_") === "replacement_hyperlink" ) && 
                       (!cellValue.startsWith("http"))
                    ) {
                        toast("Error", "Please check hyperlink format in your document", "error");
                        return false;
                    }
                    else {
                        item[columns[colIndex].toLowerCase().split(" ").join("_")] = cellValue
                    }
            }    

            // Grouping data based on the post id
            if( data.length > 0 ) {
                for (let index = 0; index < data.length; index++) {
                    if( data[index].post_id === item.post_id ) {
                        for (let iitem = 0; iitem < data[index].items.length; iitem++) { // Ignore duplicate item of each post id
                            if( data[index].items[iitem] !== item ) {
                                data[index].items.push(item)
                            }
                        }
                    }    
                    else {
                        data.push({
                            post_id: item.post_id,
                            items: [
                                item
                            ]
                        })
                    }
                }
            }  
            else {
                data.push({
                    post_id: item.post_id,
                    items: [
                        item
                    ]
                })
            }
        }  
        return data;
    }  
    
    getTableColumns = (jsondata) => {
        var columnSet = [];  
        for (var i = 0; i < jsondata.length; i++) {  
            var rowHash = jsondata[i];  
            for (var key in rowHash) {  
                if (rowHash.hasOwnProperty(key)) {  
                    if ($.inArray(key, columnSet) == -1) {
                        columnSet.push(key);  
                    }  
                }  
            }  
        }  
        return columnSet;  
    }

    toast = (
        title, 
        message, 
        type, 
        args={
            has_icon:true,
            has_close_btn:true,
            stack: true,
            fullscreen: false,
            timeout: 5000,
            sticky: false,
            has_progress: true,
            rtl: false,
            position_class: "toast-top-right"
        }
    ) => {
        $.Toast(title, message, type, args);
    }

})