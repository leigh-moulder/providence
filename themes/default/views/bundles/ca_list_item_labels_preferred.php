<?php
/* ----------------------------------------------------------------------
 * bundles/ca_list_item_labels_preferred.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009-2013 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 *
 * This source code is free and modifiable under the terms of 
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * ----------------------------------------------------------------------
 */
 
	$vs_id_prefix 		= $this->getVar('placement_code').$this->getVar('id_prefix');
	$va_labels 			= $this->getVar('labels');
	$t_label 			= $this->getVar('t_label');
	$va_initial_values 	= $this->getVar('label_initial_values');
	if (!$va_force_new_labels = $this->getVar('new_labels')) { $va_force_new_labels = array(); }	// list of new labels not saved due to error which we need to for onto the label list as new

	$va_settings = 		$this->getVar('settings');
	$vs_add_label =		$this->getVar('add_label');
	
	$vb_read_only		=	((isset($va_settings['readonly']) && $va_settings['readonly'])  || ($this->request->user->getBundleAccessLevel('ca_list_items', 'preferred_labels') == __CA_BUNDLE_ACCESS_READONLY__));
	
	print caEditorBundleShowHideControl($this->request, $vs_id_prefix.'Labels', $va_settings, caInitialValuesArrayHasValue($vs_id_prefix.'Labels', $va_initial_values));
	print caEditorBundleMetadataDictionary($this->request, $vs_id_prefix.'Labels', $va_settings);
?>
<div id="<?php print $vs_id_prefix; ?>Labels">
<?php
	//
	// The bundle template - used to generate each bundle in the form
	//
?>
	<textarea class='caLabelTemplate' style='display: none;'>
		<div id="{fieldNamePrefix}Label_{n}" class="labelInfo">
			<div style="float: right;">
				<a href="#" class="caDeleteLabelButton"><?php print caNavIcon($this->request, __CA_NAV_BUTTON_DEL_BUNDLE__); ?></a>
			</div>
			<table>
				<tr valign="middle">
					<td>
						<table>
							<tr>
								<td>
									<?php print $t_label->htmlFormElement('name_singular', null, array('name' => "{fieldNamePrefix}name_singular_{n}", 'id' => "{fieldNamePrefix}name_singular_{n}", "value" => "{{name_singular}}", 'no_tooltips' => false, 'textAreaTagName' => 'textentry', 'readonly' => $vb_read_only, 'tooltip_namespace' => 'bundle_ca_list_item_labels_preferred')); ?>
								</td>
							</tr>
							<tr>
								<td>
									<?php print $t_label->htmlFormElement('name_plural', null, array('name' => "{fieldNamePrefix}name_plural_{n}", 'id' => "{fieldNamePrefix}name_plural_{n}", "value" => "{{name_plural}}", 'no_tooltips' => false, 'textAreaTagName' => 'textentry', 'readonly' => $vb_read_only, 'tooltip_namespace' => 'bundle_ca_list_item_labels_preferred')); ?>
								</td>
							</tr>
							<tr>
								<td>
									<?php print $t_label->htmlFormElement('description', null, array('name' => "{fieldNamePrefix}description_{n}", 'id' => "{fieldNamePrefix}description_{n}", "value" => "{{description}}", 'no_tooltips' => false, 'textAreaTagName' => 'textentry', 'readonly' => $vb_read_only, 'tooltip_namespace' => 'bundle_ca_list_item_labels_preferred')); ?><br/>
									
									<?php print '<div class="formLabel">'.$t_label->htmlFormElement('locale_id', '^LABEL ^ELEMENT', array('classname' => 'labelLocale', 'id' => "{fieldNamePrefix}locale_id_{n}", 'name' => "{fieldNamePrefix}locale_id_{n}", "value" => "{locale_id}", 'no_tooltips' => false, 'dont_show_null_value' => true, 'hide_select_if_only_one_option' => true, 'WHERE' => array('(dont_use_for_cataloguing = 0)'), 'tooltip_namespace' => 'bundle_ca_list_item_labels_preferred')); ?>
			<?php print $t_label->htmlFormElement('type_id', "^LABEL ^ELEMENT", array('classname' => 'labelType', 'id' => "{fieldNamePrefix}type_id_{n}", 'name' => "{fieldNamePrefix}type_id_{n}", "value" => "{type_id}", 'no_tooltips' => true, 'list_code' => $this->request->config->get('ca_list_items_preferred_label_type_list'), 'dont_show_null_value' => true, 'hide_select_if_no_options' => true)).'</div>'; ?>
								</td>
							<tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
<?php
	print TooltipManager::getLoadHTML('bundle_ca_list_item_labels_preferred');
?>
	</textarea>
	
	<div class="bundleContainer">
		<div class="caLabelList">
		
		</div>
		<div class="button labelInfo caAddLabelButton"><a href='#'><?php print caNavIcon($this->request, __CA_NAV_BUTTON_ADD__); ?> <?php print $vs_add_label ? $vs_add_label : _t("Add label"); ?></a></div>
	</div>
			
	
</div>
<script type="text/javascript">
	caUI.initLabelBundle('#<?php print $vs_id_prefix; ?>Labels', {
		mode: 'preferred',
		fieldNamePrefix: '<?php print $vs_id_prefix; ?>',
		templateValues: ['name_singular', 'name_plural', 'description', 'locale_id', 'type_id'],
		initialValues: <?php print json_encode($va_initial_values); ?>,
		forceNewValues: <?php print json_encode($va_force_new_labels); ?>,
		labelID: 'Label_',
		localeClassName: 'labelLocale',
		templateClassName: 'caLabelTemplate',
		labelListClassName: 'caLabelList',
		addButtonClassName: 'caAddLabelButton',
		deleteButtonClassName: 'caDeleteLabelButton',
		bundlePreview: <?php $va_cur = current($va_initial_values); print caEscapeForBundlePreview($va_cur['name_plural']); ?>,
		readonly: <?php print $vb_read_only ? "1" : "0"; ?>,
		defaultLocaleID: <?php print ca_locales::getDefaultCataloguingLocaleID(); ?>
	});
</script>
