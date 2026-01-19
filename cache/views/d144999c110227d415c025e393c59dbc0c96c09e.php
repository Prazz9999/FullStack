


<?php $__env->startSection('content'); ?>
<a href="?page=create">Add Student</a>


<table>
<tr><th>ID</th><th>Name</th><th>Email</th><th>Course</th><th>Action</th></tr>
<?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr>
<td><?php echo e($s['id']); ?></td>
<td><?php echo e($s['name']); ?></td>
<td><?php echo e($s['email']); ?></td>
<td><?php echo e($s['course']); ?></td>
<td>
<a href="?page=edit&id=<?php echo e($s['id']); ?>">Edit</a>
<a href="?page=delete&id=<?php echo e($s['id']); ?>">Delete</a>
</td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</table>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\workshop8\app\views/students/index.blade.php ENDPATH**/ ?>