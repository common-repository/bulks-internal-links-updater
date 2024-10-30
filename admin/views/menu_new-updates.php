<div class="page-wrapper">
    
    <ul class="nav nav-tabs" id="updateTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="manual-tab"  data-target="#manual" type="button">
                <span class="dashicons dashicons-update"></span>
                Manual Updates
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="excel-tab" data-target="#excel" type="button">
                <span class="dashicons dashicons-cloud-upload"></span>
                Excel Updates
            </button>
        </li>
    </ul>

    <div class="tab-content" id="updateTabContent">
        <div class="tab-pane active" id="manual" role="tabpanel" aria-labelledby="manual-tab">

            <?php
                do_action( 'mbulet_ilu_update_manual_content' );
            ?>

        </div>
        <div class="tab-pane" id="excel" role="tabpanel" aria-labelledby="excel-tab">
            
            <?php
                do_action( 'mbulet_ilu_update_excel_content' );
            ?>

        </div>
    </div>
</div>