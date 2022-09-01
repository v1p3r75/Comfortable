<div class="direction">
    <span class="fw-bold m-name text-capitalize"></span>
    <span><i class="mx-1">|</i><i class="fa fa-home cl-link"></i><i class="fa fa-angle-right mx-1"></i></span>
    <span class="text-capitalize"><span class="m-name"></span> list</span>
</div>
<div class="mt-5">
    <a href="javascript:void(0)" class="text-capitalize btn-add ui-action" data-display-target='popup-add'>Add new <span class="m-name"></span></a>
</div>
<div class="list mt-5">
    <div class="table-responsive">
        <table class="table table-default" style="border-collapse: unset;">
            <thead>
            <tr>
				<?php foreach($columns as $k): ?>
                    <th scope="col" class="text-capitalize"><?php
                        echo $k['Field']; echo strstr($k['Extra'], 'increment') ? '<i class="fa fa-key ms-2"></i>' : '' ?>
                    </th>
				<?php endforeach; ?>
                <th scope="col" class="text-capitalize">Action</th>
            </tr>
            </thead>
            <tbody>
			<?php foreach($data as $k): ?>
                <tr data-cf-data='<?= json_encode($k) ?>'>
					<?php foreach($k as $v => $c): ?>
                        <td scope="col"><?= $k[$v] ?></td>
					<?php endforeach; ?>
                    <td class="d-flex gap-2">
                        <button title="Renommer" class="btn btn-default text-center cl-link ui-action action" data-display-target-update="popup-update" data-cf-action-type='update'><i class="fa fa-pen"></i></button>
                        <button title="Supprimer" class="btn btn-default text-center text-danger ui-action action" data-display-target="popup-confirm" data-cf-action-type='del'><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
			<?php endforeach; ?>
            </tr>

            </tbody>
        </table>
        <div class=" d-flex justify-content-end px-5 gap-4">
            <a href="javascript:void(0)"><i class="fa fa-angle-left"></i></a>
            <a href="javascript:void(0)" class="cl-link">1</a>
            <a href="javascript:void(0)">2</a>
            <a href="javascript:void(0)">3</a>
            <a href="javascript:void(0)"><i class="fa fa-angle-right"></i></a>
        </div>
    </div>

</div>
<input type="hidden" class="cf-xxx-primaryKey" value="<?= $primaryKey ?>">
<div class="popup-add-up popup-add ui-model position-absolute text-black bg-white rounded-3 p-3 d-none h-80 overflow-auto">
    <form action="/admin/crud" method="POST">
        <div class="d-flex justify-content-between">
            <h4>Add Data</h4>
            <h4 role="button"><i class="fa fa-close close-model"></i></h4>
        </div>
        <div class="form d-flex flex-wrap gap-4 my-5">
			<?= $form ?>
            <input type="hidden" name="cf-xxx-model" value="" class="model-name">
        </div>
        <div class="d-flex justify-content-end mt-5">
            <div class="position-relative send-ctn" style="width: 20%; height: 40px">
                <input type="submit" value="Save" class="send w-100 h-100" data-cf-action-type='add'>
                <img src="/public/admin/static/img/loader.gif" alt="loading" class="send-wait d-none position-absolute top-0 start-0 w-100 h-100">
            </div>
        </div>
    </form>
</div>
<div class="popup-add-up popup-update ui-model position-absolute text-black bg-white rounded-3 p-3 d-none h-80 overflow-auto">
    <form action="/admin/crud" method="POST">
        <div class="d-flex justify-content-between">
            <h4>Update Data</h4>
            <h4 role="button"><i class="fa fa-close close-model"></i></h4>
        </div>
        <div class="form d-flex flex-wrap gap-4 my-5">
			<?= $form ?>
            <input type="hidden" name="cf-xxx-model" value="" class="model-name">
        </div>
        <div class="d-flex justify-content-end mt-5">
            <div class="position-relative send-ctn" style="width: 20%; height: 40px">
                <input type="submit" value="Save" class="send w-100 h-100" data-cf-action-type='update'>
                <img src="/public/admin/static/img/loader.gif" alt="loading" class="send-wait d-none position-absolute top-0 start-0 w-100 h-100">
            </div>
        </div>
    </form>
</div>
<div class="popup-confirm ui-model position-absolute text-black bg-white rounded-3 p-3 d-none">
    <form action="/admin/crud" method="POST">
        <h6>Confirm</h6>
        <p>Are you sure to delete ?</p>
        <div class="d-flex justify-content-between">
            <input type="hidden" name="cf-xxx-model" value="" class="model-name">
            <div class="position-relative sendBtn">
                <input type="submit" value="Yes" class="send close-model" data-cf-action-type="del">
                <img src="/public/admin/static/img/loader.gif" alt="loading" class="send-wait d-none position-absolute top-0 start-0 w-100 h-100">
            </div>
            <a href="javascript:void(0)" class="no close-model" >No</a>
        </div>
    </form>
</div>
<script src="/public/admin/static/js/ui.js"></script>