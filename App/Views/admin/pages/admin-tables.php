<div class="direction">
    <span class="fw-bold">Tables</span>
    <span><i class="mx-1">|</i><i class="fa fa-home cl-link"></i><i class="fa fa-angle-right mx-1"></i></span>
    <span>Database Tables</span>
</div>
<div class='search-bar'> 
    inp
</div>
<div class="tables d-flex flex-wrap gap-4 mt-5">
    <?php foreach($data as $table => $value): ?>
        <?php foreach($value as $tableName): ?>
            <a class="table-i loadPage" href="javascript:void(0)" data-cf-page='view-table-<?= $tableName ?>'>
                <h4 class="table-name"><?= $tableName ?></h4>
            </a>
        <?php endforeach; ?>
    <?php endforeach; ?>
</div>

<script src="/public/admin/static/js/ui.js"></script>