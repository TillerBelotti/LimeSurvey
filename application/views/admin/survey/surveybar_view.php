<?php
/**
 * Display the survey bar. 
 * Used for all survey editing action, and group / questions lists.
 */
?>
<div class='menubar surveybar' id="surveybarid">
    <div class='row container-fluid'>
    	<div class="col-md-12">

        <!-- Add a new group --> 
		<?php if(isset($surveybar['buttons']['newgroup'])):?>
			<?php if ($activated == "Y"): ?>
				<span class="btntooltip" data-toggle="tooltip" data-placement="bottom" title="<?php eT("This survey is currently active."); ?>" style="display: inline-block" data-toggle="tooltip" data-placement="bottom" title="<?php eT('Survey cannot be activated. Either you have no permission or there are no questions.'); ?>">
					<button type="button" class="btn btn-default btntooltip" disabled="disabled">
						<img src="<?php echo Yii::app()->getBaseUrl(true);?>/images/lime-icons/328637/add.png" />
						<?php eT("Add new group to survey"); ?>
					</button>
				</span>				
			<?php elseif(Permission::model()->hasSurveyPermission($surveyid,'surveycontent','create')): ?>			
				<a class="btn btn-default" href="<?php echo $this->createUrl("admin/questiongroups/sa/add/surveyid/$surveyid"); ?>" role="button">
					<img src="<?php echo Yii::app()->getBaseUrl(true);?>/images/lime-icons/328637/add.png" />
					<?php eT("Add new group to survey");?>
				</a>
			<?php endif;?>				
		<?php endif;?>    		

        <!-- Add a new question --> 
		<?php if(isset($surveybar['buttons']['newquestion'])):?>
			<?php if ($activated == "Y"): ?>
				<span class="btntooltip" data-toggle="tooltip" data-placement="bottom" title="<?php eT("This survey is currently active."); ?>" style="display: inline-block" data-toggle="tooltip" data-placement="bottom" title="<?php eT('Survey cannot be activated. Either you have no permission or there are no questions.'); ?>">
					<button type="button" class="btn btn-default btntooltip" disabled="disabled">
						<img src="<?php echo Yii::app()->getBaseUrl(true);?>/images/lime-icons/328637/add.png" />
						<?php eT("Add new question"); ?>
					</button>
				</span>				
			<?php elseif(Permission::model()->hasSurveyPermission($surveyid,'surveycontent','create')): ?>
				<?php if(!$surveyHasGroup): ?>
					<span class="btntooltip" data-toggle="tooltip" data-placement="bottom" title="<?php eT("You must first create a question group."); ?>" style="display: inline-block" data-toggle="tooltip" data-placement="bottom" title="<?php eT('Survey cannot be activated. Either you have no permission or there are no questions.'); ?>">
						<button type="button" class="btn btn-default btntooltip" disabled="disabled">
							<img src="<?php echo Yii::app()->getBaseUrl(true);?>/images/lime-icons/328637/add.png" />
							<?php eT("Add new question"); ?>
						</button>
					</span>				
				<?php else:?>
				<a class="btn btn-default" href='<?php echo $this->createUrl("admin/questions/sa/newquestion/surveyid/".$surveyid); ?>' role="button">
					<img src="<?php echo Yii::app()->getBaseUrl(true);?>/images/lime-icons/328637/add.png" />
					<?php eT("Add new question"); ?>
				</a>
				<?php endif; ?>
			<?php endif; ?>
		<?php endif;?>

        <!-- Left buttons for survey summary -->    		
    	<?php if(isset($surveybar['buttons']['view'])):?>
    	    
            <!-- survey activation -->            
    		<?php if(!$activated): ?>
    		    
    		    <!-- activate -->
    			<?php if($canactivate): ?>
    				<a class="btn btn-success" href="<?php echo $this->createUrl("admin/survey/sa/activate/surveyid/$surveyid"); ?>" role="button">
    					<?php eT("Activate this Survey"); ?>
    				</a>	
    		    
    		    <!-- can't activate -->	
    			<?php else : ?>
                    <span class="btntooltip" data-toggle="tooltip" data-placement="bottom" title="<?php eT("This survey is currently active."); ?>" style="display: inline-block" data-toggle="tooltip" data-placement="bottom" title="<?php eT('Survey cannot be activated. Either you have no permission or there are no questions.'); ?>">
                    	<button type="button" class="btn btn-success btntooltip" disabled="disabled">
                    		<?php eT("Activate this Survey"); ?>
                    	</button>
                    </span>
    			<?php endif; ?>
    		<?php else : ?>
    		    
    		    <!-- activate expired survey -->
    			<?php if($expired) : ?>
    		    	<span class="btntooltip" data-toggle="tooltip" data-placement="bottom" title="<?php eT("This survey is currently active."); ?>" style="display: inline-block" data-toggle="tooltip" data-placement="bottom" title="<?php eT('This survey is active but expired.'); ?>">				
    					<button type="button" class="btn btn-success  btntooltip" disabled="disabled">
    						<?php eT("Activate this Survey"); ?>
    					</button>
    				</span>		
    			<?php elseif($notstarted) : ?>
    		    	<span class="btntooltip" data-toggle="tooltip" data-placement="bottom" title="<?php eT("This survey is currently active."); ?>" style="display: inline-block" data-toggle="tooltip" data-placement="bottom" title='<?php eT("This survey is active but has a start date."); ?>'>				
    					<button type="button" class="btn btn-success  btntooltip" disabled="disabled" >
    						<?php eT("Activate this Survey"); ?>
    					</button>		
    				</span>			    	
    			<?php endif; ?>
                
                <!-- Stop survey -->    			
    			<?php if($canactivate): ?>
    				<a class="btn btn-danger btntooltip" href="<?php echo $this->createUrl("admin/survey/sa/deactivate/surveyid/$surveyid"); ?>" role="button">
    					<?php eT("Stop this survey"); ?>
    				</a>	    	
    			<?php endif; ?>
    		<?php endif; ?>


            <!-- Preview/Execute survey -->
    		<?php if($activated || $surveycontent) : ?>
    		    
    		    <!-- Multinlinguage -->
    		    <?php if(count($languagelist)>1): ?>
                    <div class="btn-group">
                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="<?php echo Yii::app()->getBaseUrl(true);?>/images/lime-icons/328637/preview.png" />
                        <?php echo $icontext;?> <span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu" style="min-width : 252px;">
                        <?php foreach ($languagelist as $tmp_lang): ?>
                            <li>
                                <a target='_blank' href='<?php echo $this->createUrl("survey/index",array('sid'=>$surveyid,'newtest'=>"Y",'lang'=>$tmp_lang));?>'>
                                    <?php echo getLanguageNameFromCode($tmp_lang,false); ?>
                                </a>
                            </li>   
                        <?php endforeach; ?>
                      </ul>
                    </div>		
                
                <!-- uniq language -->        
    		    <?php else: ?>
                    <a accesskey='d' class="btn btn-default  btntooltip" href="<?php echo $this->createUrl("survey/index/sid/$surveyid/newtest/Y/lang/$baselang"); ?>" role="button"  accesskey='d' target='_blank'>
                        <img src="<?php echo Yii::app()->getBaseUrl(true);?>/images/lime-icons/328637/do.png" />
                        <?php echo $icontext;?>
                    </a>
    		    <?php endif;?>
    		<?php endif; ?>

			<!-- Survey Properties -->
			<?php if( !isset($surveybar['active_survey_properties']) ):?>
			<div class="btn-group">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                	<img src="<?php echo Yii::app()->getBaseUrl(true);?>/images/lime-icons/328637/edit.png" />
                  <?php eT("Survey properties");?> <span class="caret"></span>
                </button>
                
                <ul class="dropdown-menu">
                    <?php if($surveylocale && $surveysettings) { ?>
                        <li><a href='<?php echo $this->createUrl("admin/survey/sa/editlocalsettings/surveyid/$surveyid");?>'>
                            <img src='<?php echo $sImageURL;?>edit_30.png' alt=''/> <?php eT("Edit text elements and general settings");?></a></li>
                        <?php } ?>
                    <?php if($surveysecurity) { ?>
                        <li><a href='<?php echo $this->createUrl("admin/surveypermission/sa/view/surveyid/$surveyid");?>' >
                            <img src='<?php echo $sImageURL;?>survey_security_30.png' alt=''/> <?php eT("Survey permissions");?></a></li>
                        <?php } ?>
                    
                    <?php if($quotas) { ?>
                        <li><a href='<?php echo $this->createUrl("admin/quotas/sa/index/surveyid/$surveyid/");?>' >
                            <img src='<?php echo $sImageURL;?>quota_30.png' alt=''/> <?php eT("Quotas");?></a></li>
                        <?php } ?>
                    <?php if($assessments) { ?>
                        <li><a href='<?php echo $this->createUrl("admin/assessments/sa/index/surveyid/$surveyid");?>' >
                            <img src='<?php echo $sImageURL;?>assessments_30.png' alt=''/> <?php eT("Assessments");?></a></li>
                        <?php } ?>
                    <?php if($surveylocale) { ?>
                        <li><a href='<?php echo $this->createUrl("admin/emailtemplates/sa/index/surveyid/$surveyid");?>' >
                            <img src='<?php echo $sImageURL;?>emailtemplates_30.png' alt=''/> <?php eT("Email templates");?></a></li>
                        <?php } ?>
                    
                    <?php if($surveycontent): ?>
                        <?php if($onelanguage): ?>
                            <li>
                            	<a href='<?php echo $this->createUrl("admin/expressions/sa/survey_logic_file/sid/$surveyid/");?>' >
                                	<img src='<?php echo $sImageURL;?>quality_assurance_30.png' alt='' /> <?php eT("Survey logic file");?>
                                </a>
                            </li>
                            <?php else : ?>
                            <li role="separator" class="divider"></li>
                    		<li class="dropdown-header"><?php eT("Survey logic file");?></li>
                    			<?php foreach ($languagelist as $tmp_lang): ?>
                    			    <li>
                    			    	<a  href='<?php echo $this->createUrl("admin/expressions/sa/survey_logic_file/sid/$surveyid/lang/$tmp_lang");?>'>
                    			       		<img src='<?php echo $sImageURL;?>quality_assurance.png' alt='' /> 
                    			       		<?php echo getLanguageNameFromCode($tmp_lang,false);?>
                    			       	</a>
                    			   	</li>
                    			<?php endforeach; ?>
                            <?php endif; ?>
                    <?php endif; ?>
			  </ul>
			</div>
			<?php else:?>
					<button type="button" class="btn btn-default btntooltip active">
						<img src="<?php echo Yii::app()->getBaseUrl(true);?>/images/lime-icons/328637/<?php echo $surveybar['active_survey_properties']['img'];?>" />
						<?php echo $surveybar['active_survey_properties']['txt'];?>
					</button>
			<?php endif;?>
			

			<!-- TOOLS  -->
			<div class="btn-group">
			  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			  	<img src="<?php echo Yii::app()->getBaseUrl(true);?>/images/lime-icons/328637/tools.png" />
			   	<?php eT('Tools');?><span class="caret"></span>
			  </button>
			  <ul class="dropdown-menu">
                    <?php if ($surveydelete) { ?>
                        <li><a href="<?php echo $this->createUrl("admin/survey/sa/delete/surveyid/{$surveyid}"); ?>">
                            <img src='<?php echo $sImageURL;?>delete_30.png' alt=''/> <?php eT("Delete survey");?></a></li>
                        <?php } ?>
                    <?php if ($surveytranslate) {
                            if($hasadditionallanguages) { ?>
                            <li><a href="<?php echo $this->createUrl("admin/translate/sa/index/surveyid/{$surveyid}");?>">
                                <img src='<?php echo $sImageURL;?>translate_30.png' alt=''/> <?php eT("Quick-translation");?></a></li>
                            <?php } else { ?>
                            <li><a href="#" onclick="alert('<?php eT("Currently there are no additional languages configured for this survey.", "js");?>');" >
                                <img src='<?php echo $sImageURL;?>translate_disabled_30.png' alt=''/> <?php eT("Quick-translation");?></a></li>
                            <?php } ?>
                        <?php } ?>
                    <?php if (Permission::model()->hasSurveyPermission($surveyid,'surveycontent','update')) { ?>
                        <li>
                            <?php if ($conditionscount>0){?>
                                <a href="<?php echo $this->createUrl("/admin/conditions/sa/index/subaction/resetsurveylogic/surveyid/{$surveyid}"); ?>">
                                <img src='<?php echo $sImageURL;?>resetsurveylogic_30.png' alt=''/><?php eT("Reset conditions");?></a>
                            <?php } else {?>
                                <a href="#" onclick="alert('<?php eT("Currently there are no conditions configured for this survey.", "js"); ?>');" >
                                <img src='<?php echo $sImageURL;?>resetsurveylogic_disabled_30.png' alt=''/> <?php eT("Reset conditions");?></a>
                            <?php } ?>
                        </li>
                        <?php if(!$activated) { ?>
                        <li>
                        		<li role="separator" class="divider"></li>
                                <li class="dropdown-header"><?php eT("Regenerate question codes");?></li>
                                <li>
                                <a href="<?php echo $this->createUrl("/admin/survey/regenquestioncodes/surveyid/{$surveyid}/subaction/straight"); ?>">
                                <img src='<?php echo $sImageURL;?>resetsurveylogic_30.png' alt=''/><?php eT("Straight");?></a></li>
                                <li>
                                <a href="<?php echo $this->createUrl("/admin/survey/regenquestioncodes/surveyid/{$surveyid}/subaction/bygroup"); ?>">
                                <img src='<?php echo $sImageURL;?>resetsurveylogic_30.png' alt=''/><?php eT("By question group");?></a></li>
                        </li>
                        <?php } ?>
                    <?php } ?>
			  </ul>
			</div>
    		

			<!-- Display / Export -->
			<div class="btn-group">
			  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			  	<img src="<?php echo Yii::app()->getBaseUrl(true);?>/images/lime-icons/328637/display_export.png" />
			    <?php eT("Display / Export");?> <span class="caret"></span>
			  </button>
			  <ul class="dropdown-menu">

                    <?php if($surveyexport): ?>
                    	<li class="dropdown-header"> <?php eT("Export...");?></li>

                            <?php if($surveyexport) { ?>
                                <li><a href='<?php echo $this->createUrl("admin/export/sa/survey/action/exportstructurexml/surveyid/$surveyid");?>' >
                                    <img src='<?php echo $sImageURL;?>export_30.png' alt='' /> <?php eT("Survey structure (.lss)");?></a>
                                </li>
                                <?php } ?>
                            <?php if($respstatsread && $surveyexport) {
                                    if ($activated){?>
                                    <li><a href='<?php echo $this->createUrl("admin/export/sa/survey/action/exportarchive/surveyid/$surveyid");?>' >
                                        <img src='<?php echo $sImageURL;?>export_30.png' alt='' /> <?php eT("Survey archive (.lsa)");?></a></li>
                                    <?php }
                                    else
                                    {?>
                                    <li><a href="#" onclick="alert('<?php eT("You can only archive active surveys.", "js");?>');" >
                                        <img src='<?php echo $sImageURL;?>export_disabled_30.png' alt='' /> <?php eT("Survey archive (.lsa)");?></a></li><?php
                                    }
                            }?>
                            <?php if($surveyexport) { ?>
                                <li><a href='<?php echo $this->createUrl("admin/export/sa/survey/action/exportstructurequexml/surveyid/$surveyid");?>' >
                                    <img src='<?php echo $sImageURL;?>export_30.png' alt='' /> <?php eT("queXML format (*.xml)");?></a>
                                </li>
                                <li><a href='<?php echo $this->createUrl("admin/export/sa/survey/action/exportstructuretsv/surveyid/$surveyid");?>' >
                                    <img src='<?php echo $sImageURL;?>export_30.png' alt='' /> <?php eT("Tab-separated-values format (*.txt)");?></a>
                                </li>
                                <?php } ?>

                        <?php endif;?>

                    <?php if(Permission::model()->hasSurveyPermission($surveyid,'surveycontent','read')) { ?>
                        <?php if($onelanguage) { ?>
                            <li>
                            	<a target='_blank' href='<?php echo $this->createUrl("admin/printablesurvey/sa/index/surveyid/$surveyid");?>' >
                                	<img src='<?php echo $sImageURL;?>print_30.png' alt='' /> <?php eT("Printable version");?>
                                </a>
                            </li>
                            <?php } else { ?>
							<li role="separator" class="divider"></li>
							<li class="dropdown-header"><?php eT("Printable version");?></li>                            	
                                    <?php foreach ($languagelist as $tmp_lang) { ?>
                                        <li><a accesskey='d' target='_blank' href='<?php echo $this->createUrl("admin/printablesurvey/sa/index/surveyid/$surveyid/lang/$tmp_lang");?>'>
                                            <img src='<?php echo $sImageURL;?>print_30.png' alt='' /> <?php echo getLanguageNameFromCode($tmp_lang,false);?></a></li>
                                        <?php } ?>
                            <?php } ?>
                        <?php } ?>
                        
                    <?php if($surveyexport) {
                            if($onelanguage) { ?>
                            <li>
                            	<a href='<?php echo $this->createUrl("admin/export/sa/showquexmlsurvey/surveyid/$surveyid");?>' >
                                	<img src='<?php echo $sImageURL;?>export_30.png' alt='' /> <?php eT("QueXML export");?>
                                </a>
                            </li>
                            <?php } else { ?>
							<li role="separator" class="divider"></li>
							<li class="dropdown-header"><?php eT("QueXML export");?></li>                            	                            	
                                    <?php foreach ($languagelist as $tmp_lang) { ?>
                                        <li>
                                        	<a accesskey='d' target='_blank' href='<?php echo $this->createUrl("admin/export/sa/showquexmlsurvey/surveyid/$surveyid/lang/$tmp_lang");?>'>
                                            	<img src='<?php echo $sImageURL;?>export_30.png' alt=''/> <?php echo getLanguageNameFromCode($tmp_lang,false);?>
                                            </a>
                                        </li>
                                        <?php } ?>
                            <?php }
                    } ?>
			  	
			  </ul>
			</div>

			<!-- Token -->
            <?php if($tokenmanagement):?>
			<a class="btn btn-default  btntooltip" href="<?php echo $this->createUrl("admin/tokens/sa/index/surveyid/$surveyid"); ?>" role="button">
				<img src="<?php echo Yii::app()->getBaseUrl(true);?>/images/lime-icons/328637/tokens.png" />
				<?php eT("Token management");?>
			</a>
            <?php endif; ?>
            
            <!-- Statistics -->
            <?php if($respstatsread || $responsescreate || $responsesread):?>
            <div class="btn-group">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="<?php echo Yii::app()->getBaseUrl(true);?>/images/lime-icons/328637/responses.png" />
                    <?php eT("Responses");?><span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                <?php if($respstatsread):?>
                    <?php if($activated):?>
                        <li>
                            <a href='<?php echo $this->createUrl("admin/responses/sa/index/surveyid/$surveyid/");?>' >
                                <?php eT("Responses & statistics");?>
                            </a>
                        </li>                        
                    <?php else:?>
                        <li>
                            <a href="#" onclick="alert('<?php eT("This survey is not active - no responses are available.","js");?>');" >
                                <img src='<?php echo $sImageURL;?>browse_disabled_30.png' alt='' /> <?php eT("Responses & statistics");?>
                            </a>
                        </li>                        
                    <?php endif; ?>
                <?php endif; ?>
                                    <?php if($responsescreate) {
                            if($activated) { ?>
                            <li><a href='<?php echo $this->createUrl("admin/dataentry/sa/view/surveyid/$surveyid");?>' >
                                <img src='<?php echo $sImageURL;?>dataentry_30.png' alt='' /> <?php eT("Data entry screen");?></a></li>
                            <?php } else { ?>
                            <li><a href="#" onclick="alert('<?php eT("This survey is not active, data entry is not allowed","js");?>');" >
                                <img src='<?php echo $sImageURL;?>dataentry_disabled_30.png' alt='' /> <?php eT("Data entry screen");?></a></li>
                            <?php }
                    } ?>
                    <?php if($responsesread) {
                            if($activated) { ?>
                            <li><a href='<?php echo $this->createUrl("admin/saved/sa/view/surveyid/$surveyid");?>' >
                                <img src='<?php echo $sImageURL;?>saved_30.png' alt='' /> <?php eT("Partial (saved) responses");?></a></li>
                            <?php } else { ?>
                            <li><a href="#" onclick="alert('<?php eT("This survey is not active - no responses are available","js");?>');" >
                                <img src='<?php echo $sImageURL;?>saved_disabled_30.png' alt='' /> <?php eT("Partial (saved) responses");?></a></li>
                            <?php }
                    } ?>                    
                </ul>
            </div>
            <?php endif;?>
			    		
    	<?php endif;?>	
    	</div>
    	
        <!-- right action buttons -->      
    	<div class="col-md-offset-8 col-md-4 text-right">
    		<?php if(isset($surveybar['savebutton']['form'])):?>
            	<a class="btn btn-success" href="#" role="button" id="save-button" data-use-form-id="<?php if (isset($surveybar['savebutton']['useformid'])){ echo '1';}?>" data-form-to-save="<?php if (is_string($surveybar['savebutton']['form'])) {echo $surveybar['savebutton']['form']; }?>">
            		<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
            		<?php eT("Save");?>
            	</a>
            	<a class="btn btn-default" href="#" role="button">
            		<span class="glyphicon glyphicon-saved" aria-hidden="true"></span>
            		<?php eT("Save and close");?>
            	</a>
            <?php endif;?>
            
            <?php if(isset($surveybar['closebutton']['url'])):?>
            	<a class="btn btn-danger" href="<?php echo $this->createUrl($surveybar['closebutton']['url']); ?>" role="button">
            		<span class="glyphicon glyphicon-close" aria-hidden="true"></span>
            		<?php eT("Close");?>
            	</a>
            <?php endif;?>
    	</div>
    </div>
</div>