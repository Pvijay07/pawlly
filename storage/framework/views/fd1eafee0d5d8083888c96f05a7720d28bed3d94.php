<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(["extra"=>""]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(["extra"=>""]); ?>
<?php foreach (array_filter((["extra"=>""]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<div class="container">
    <div class="row justify-content-center align-items-center vh-100">
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        <?php echo e($logo); ?>

                    </div>

                    <div>
                        <?php echo e($slot); ?>

                    </div>

                    <div class="text-center mt-3 d-none">
                        <?php echo e($extra); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /home/xhtmlreviews/public_html/fitinex.xhtmlreviews.com/resources/views/components/auth-card.blade.php ENDPATH**/ ?>