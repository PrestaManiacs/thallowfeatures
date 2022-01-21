{*
* 2006-2022 THECON SRL
*
* NOTICE OF LICENSE
*
* DISCLAIMER
*
* YOU ARE NOT ALLOWED TO REDISTRIBUTE OR RESELL THIS FILE OR ANY OTHER FILE
* USED BY THIS MODULE.
*
* @author    THECON SRL <contact@thecon.ro>
* @copyright 2006-2022 THECON SRL
* @license   Commercial
*}

{extends file="helpers/form/form.tpl"}
{block name="input_row"}
    {if $input.type == 'custom_feature_choice'}
        <div class="form-group">
            <label class="control-label {if $input.th_ps_sub_version eq 8}col-lg-4{else}col-lg-3{/if}">
                {$input.label_custom|escape:'htmlall':'UTF-8'}
            </label>
            <div class="col-xs-12 col-lg-3 th_position">
                <div class="th_allow_features">
                    {foreach from=$input.values item=item}
                         {assign var=checked value=''}
                         {if $item.id_feature|in_array:$input.values_db}
                             {assign var=checked value='checked'}
                         {/if}
                        <div class="th_allow_feature">
                            <div class="th_allow_features_wrapper">
                                <div class="th_allow_features_name">
                                    {$item.name|escape:'htmlall':'UTF-8'}
                                </div>
                                <div class="th_allow_features_active">
                                    <input type="checkbox" name="th_allow_features_checkbox[]" value="{$item.id_feature|escape:'htmlall':'UTF-8'}" {$checked|escape:'htmlall':'UTF-8'}>
                                </div>
                            </div>
                        </div>
                    {/foreach}
                </div>
            </div>
        </div>
    {else}
        {$smarty.block.parent}
    {/if}
{/block}
