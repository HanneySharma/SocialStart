<div class="dataTables_length socialstartscustom">
    <label class="page_count_dropdown socialstartscustompagedrop">
        <p class="paddingtop5">Show</p> 
        <select onchange="javascript:ajaxPagination('<?php echo $functionName;?>', 'paginationCountChange');" name="DataTables_Table_0_length" class="form-control input-sm page_no_select margin10" id="pageListCount">
            <option value="5" <?php if($paginationCountChange == 5){echo "selected";}?>>5</option>
            <option value="10" <?php if($paginationCountChange == 10){echo "selected";}?>>10</option>
            <option value="25" <?php if($paginationCountChange == 25){echo "selected";}?>>25</option>
            <option value="50" <?php if($paginationCountChange == 50){echo "selected";}?>>50</option>
            <option value="100" <?php if($paginationCountChange == 100){echo "selected";}?>>100</option>
        </select> <p class="paddingtop5">entries</p>
    </label>
</div>