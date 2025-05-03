<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="theme-fs-sm">

<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="<?php echo e(setting('favicon')); ?>">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo e(setting('favicon')); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo e(setting('meta_description')); ?>">
    <meta name="keyword" content="<?php echo e(setting('meta_keyword')); ?>">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="setting_options" content="<?php echo e(setting('customization_json')); ?>">

    <title><?php echo e($title); ?> - <?php echo e(app_name()); ?></title>
    <!-- Styles -->
    <?php echo $__env->yieldPushContent('before-styles'); ?>
    <!-- Styles -->
    <link rel="stylesheet" href="<?php echo e(asset('css/hope-ui.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/pro.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/dark.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/rtl.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('custom-css/dashboard.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/customizer.css')); ?>">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;700&display=swap" rel="stylesheet">
    <?php echo $__env->yieldPushContent('after-styles'); ?>

    <!-- Analytics -->
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.google-analytics','data' => ['config' => ''.e(setting('google_analytics')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('google-analytics'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['config' => ''.e(setting('google_analytics')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

    <style>
      <?php echo setting('custom_css_block'); ?>

    </style>
</head>

<body>
    <!-- Loader Start -->
    <div id="loading">
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.partials._body_loader','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('partials._body_loader'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
    </div>
    <!-- Loader End -->
    <div>
        <?php echo e($slot); ?>

    </div>
    <!-- Scripts -->
    <script src="<?php echo e(asset('js/backend.js')); ?>"></script>

    <script>
      <?php echo setting('custom_js_block'); ?>

    </script>
</body>

</html>
<?php /**PATH /home/xhtmlreviews/public_html/fitinex.xhtmlreviews.com/resources/views/layouts/auth.blade.php ENDPATH**/ ?>