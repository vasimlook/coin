</div>
<!-- wrap @e -->
</div>
<!-- main @e -->
</div>
<!-- app-root @e -->
<!-- JavaScript -->
<input type="hidden" name="csrf_test_name" value="<?php echo csrf_hash(); ?>" id="csrf_test_name">
<script src="<?php echo ASSETS_DIR_LINK; ?>template/assets/js/bundle.js"></script>
<script src="<?php echo ASSETS_DIR_LINK; ?>template/assets/js/scripts.js"></script>
<script src="<?php echo ASSETS_DIR_LINK; ?>template/assets/js/example-sweetalert.js"></script>
<script src="<?php echo ASSETS_DIR_LINK; ?>template/assets/js/libs/editors/summernote.js" type="text/javascript"></script>

<!-- datatable start js  -->
<script src="<?php echo ASSETS_DIR_LINK; ?>central/datatable/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo ASSETS_DIR_LINK; ?>central/datatable/dataTables.responsive.min.js" type="text/javascript"></script>

<!-- common javascript for all project -->
<?php include(APPPATH . "Views/notify.php"); ?>
<?php include(APPPATH . "Views/common_admin_js.php"); ?>
<!-- include javascript page wise -->
<?php if ($title == ADMIN_USER_LIST_TITLE) { include(APPPATH . "Views/admin/js/user_list_js.php"); } ?>
<?php if ($title == ADMIN_USER_PROFILE_TITLE) { include(APPPATH . "Views/admin/js/user_profile_js.php"); } ?>
<?php if ($title == ADMIN_COIN_LIST_TITLE) { include(APPPATH . "Views/admin/js/coin_list_js.php"); } ?>
</body>
</html>