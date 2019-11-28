<!-- Plugins - core -->
<script type="text/javascript" src="/assets/plugins/jquery/jquery-2.2.2.min.js?version=<?=project('version')?>"></script>
<script type="text/javascript" src="/assets/plugins/swipebox/jquery.swipebox.min.js?version=<?=project('version')?>"></script>
<? if (isset($datatable)) : ?>
	<script type="text/javascript" src="/assets/plugins/datatables/datatables.min.js?version=<?=project('version')?>"></script>
	<script type="text/javascript" src="/assets/plugins/downloader/jquery.fileDownload.js?version=<?=project('version')?>"></script>
<? endif; ?>
<script type="text/javascript" src="/assets/plugins/bootstrap/bootstrap.min.js?version=<?=project('version')?>"></script>
<script type="text/javascript" src="/assets/plugins/selectpicker/bootstrap-select.min.js?version=<?=project('version')?>"></script>
<script type="text/javascript" src="/assets/plugins/datepicker/bootstrap-datepicker.min.js?version=<?=project('version')?>"></script>
<script type="text/javascript" src="/assets/plugins/validate/jquery.validate.min.js?version=<?=project('version')?>"></script>
<script type="text/javascript" src="/assets/plugins/sweetalert/sweetalert2.js?version=<?=project('version')?>"></script>
<script type="text/javascript" src="/assets/plugins/scrollbar/jquery.scrollbar.min.js?version=<?=project('version')?>"></script>
<script type="text/javascript" src="/assets/plugins/pincode/bootstrap-pincode-input.js?version=<?=project('version')?>"></script>
<script type="text/javascript" src="/assets/plugins/timepicker/jquery.timepicker.min.js?version=<?=project('version')?>"></script>
<script type="text/javascript" src="/assets/plugins/sticky/jquery.sticky.js?version=<?=project('version')?>"></script>
<script type="text/javascript" src="/assets/plugins/dropdown/jquery.dropdown.min.js?version=<?=project('version')?>"></script>
<script type="text/javascript" src="/assets/plugins/outside/outside.js?version=<?=project('version')?>"></script>
<script type="text/javascript" src="/assets/plugins/chroma/chroma.min.js?version=<?=project('version')?>"></script>
<script type="text/javascript" src="/assets/plugins/moment/moment.min.js?version=<?=project('version')?>"></script>
<script type="text/javascript" src="/assets/plugins/izitoast/iziToast.min.js?version=<?=project('version')?>"></script>


<!-- Plugins - additional -->
<? if (isset($editor)) : ?>
	<script type="text/javascript" src="/assets/plugins/wysiwyg/tinymce.min.js?version=<?=project('version')?>"></script>
<? endif; ?>
<? if (isset($templater) || isset($tags) || isset($analytics) || isset($uploader) || isset($datatable) || isset($timeline)) : ?>
	<script type="text/javascript" src="/assets/plugins/handlebars/handlebars-v4.0.11.js?version=<?=project('version')?>"></script>
<? endif; ?>
<? if (isset($map_picker)) : ?>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCAmVv8S0uCLOuQE79PNGtC3eo5iuWpiKQ&libraries=places&language=en?version=<?=project('version')?>"></script>
<? endif; ?>
<? if (isset($equal_height)) : ?>
	<script type="text/javascript" src="/assets/plugins/equal-height/jquery.matchHeight-min.js?version=<?=project('version')?>"></script>
<? endif; ?>
<? if (isset($analytics)) : ?>
	<script type="text/javascript" src="/assets/plugins/echarts/echarts.min.js?version=<?=project('version')?>"></script>
<? endif; ?>
	

<!-- Scripts - core -->
<script src="/assets/scripts/core.js?version=<?=project('version')?>"></script>
<script src="/assets/scripts/helpers.js?version=<?=project('version')?>"></script>
<script src="/assets/scripts/components/selectpicker.js?version=<?=project('version')?>"></script>
<script src="/assets/scripts/components/alert.js?version=<?=project('version')?>"></script>
<script src="/assets/scripts/components/validate.js?version=<?=project('version')?>"></script>
<script src="/assets/scripts/main.js?v=2"></script>

<!-- Scripts - additional -->
<? if (isset($datatable)) : ?>
	<script type="text/javascript" src="/assets/scripts/table/table.js?version=<?=project('version')?>"></script>
	<script type="text/javascript" src="/assets/scripts/table/table-filters.js?version=<?=project('version')?>"></script>
<? endif; ?>
<? if (isset($editor)) : ?>
	<script type="text/javascript" src="/assets/scripts/components/wysiwyg.js?version=<?=project('version')?>"></script>
<? endif; ?>
<? if (isset($uploader)) : ?>
	<script type="text/javascript" src="/assets/scripts/components/uploader.js?version=<?=project('version')?>"></script>
	<? $this->load->view('/templates/template-uploader'); ?>
<? endif; ?>
<? if (isset($templater)) : ?>
	<script type="text/javascript" src="/assets/scripts/components/templater.js?version=<?=project('version')?>"></script>
<? endif; ?>
<? if (isset($map_picker)) : ?>
	<script type="text/javascript" src="/assets/scripts/components/map-picker.js?version=<?=project('version')?>"></script>
<? endif; ?>
<? if (isset($tags)) : ?>
	<script type="text/javascript" src="/assets/scripts/components/tags.js?version=<?=project('version')?>"></script>
<? endif; ?>
<? if (isset($timeline)) : ?>
	<script type="text/javascript" src="/assets/scripts/components/timeline.js?version=<?=project('version')?>"></script>
	<? $this->load->view('/admin/templates/template-timeline'); ?>
<? endif; ?>
<? if (isset($analytics)) : ?>
	<script type="text/javascript" src="/assets/scripts/components/analytics.js?version=<?=project('version')?>"></script>
<? endif; ?>