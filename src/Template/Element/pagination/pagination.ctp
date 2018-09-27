<?php
// Change the template for sorting to use it via AJAX
if(!isset($frm)){
    $this->Paginator->templates([
        'number' => '<li><a class="pageNumberClass" href="#" onclick="ajaxPagination(\'{{url}}\');return false;">{{text}}</a></li>',
        'nextActive' => '<li><a class="pageNumberClass" href="#" onclick="ajaxPagination(\'{{url}}\');return false;">{{text}}</a></li>',
        'prevActive' => '<li><a class="pageNumberClass" href="#" onclick="ajaxPagination(\'{{url}}\');return false;">{{text}}</a></li>',
    ]);    
}

?>
<div class="paging_simple_numbers paginate_div">
    <ul class="pagination">
        
            <?php
                echo $this->Paginator->prev('« Previous', array('escape'=>false));
                echo $this->Paginator->numbers(['modulus' => 4]);
                // echo $this->Paginator->numbers();
                echo $this->Paginator->next('Next »');
            ?>
    </ul>
</div>