</div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    <?php 
        Assets::renderJs([
            'jquery.min.js',
            'bootstrap.min.js',
            'metisMenu.min.js',
            'raphael-min.js',
            'sb-admin-2.js'
        ]); 

        if (isset($scripts) && is_array($scripts)) {
            Assets::renderJs($scripts);
        }
    ?>
</body>

</html>
