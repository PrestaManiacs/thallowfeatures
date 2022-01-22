<?php
/**
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
 */

class Product extends ProductCore
{
    public static function getFrontFeaturesStatic($id_lang, $id_product)
    {
        if (Module::isInstalled('thallowfeatures') &&
            Module::isEnabled('thallowfeatures') && Configuration::get('THALLOWFEATURES_LIVE_MODE')) {
            if (!Feature::isFeatureActive()) {
                return [];
            }

            if (!array_key_exists($id_product . '-' . $id_lang, self::$_frontFeaturesCache)) {
                $features_id = json_decode(Configuration::get('THALLOWFEATURES_DATA'), true);
                if (count($features_id) == 0) {
                    return [];
                }

                $id_features = implode(', ', array_map('intval', $features_id));

                self::$_frontFeaturesCache[$id_product . '-' . $id_lang] = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
                    '
                SELECT name, value, pf.id_feature, f.position
                FROM ' . _DB_PREFIX_ . 'feature_product pf
                LEFT JOIN ' . _DB_PREFIX_ . 'feature_lang fl ON (fl.id_feature = pf.id_feature AND fl.id_lang = ' . (int) $id_lang . ')
                LEFT JOIN ' . _DB_PREFIX_ . 'feature_value_lang fvl ON (fvl.id_feature_value = pf.id_feature_value AND fvl.id_lang = ' . (int) $id_lang . ')
                LEFT JOIN ' . _DB_PREFIX_ . 'feature f ON (f.id_feature = pf.id_feature AND fl.id_lang = ' . (int) $id_lang . ' AND f.id_feature NOT IN ('.$id_features.'))
                ' . Shop::addSqlAssociation('feature', 'f') . '
                WHERE pf.id_product = ' . (int) $id_product . ' 
                ORDER BY f.position ASC'
                );
            }

            return self::$_frontFeaturesCache[$id_product . '-' . $id_lang];
        }

        return parent::getFrontFeaturesStatic($id_lang, $id_product);
    }
}
