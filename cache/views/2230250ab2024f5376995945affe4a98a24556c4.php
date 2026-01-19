


<?php $__env->startSection('content'); ?>
<form method="post" action="?page=store">
Name: <input name="name"><br><br>
Email: <input name="email"><br><br>
Course: <input name="course"><br><br>
<button>Add</button>
</form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\workshop8\app\views/students/create.blade.php ENDPATH**/ ?>