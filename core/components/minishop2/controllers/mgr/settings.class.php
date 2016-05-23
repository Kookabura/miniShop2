<?php

if (!class_exists('msManagerController')) {
    require_once dirname(dirname(__FILE__)) . '/manager.class.php';
}

class Minishop2MgrSettingsManagerController extends msManagerController
{
    /**
     * @return string
     */
    public function getPageTitle()
    {
        return 'miniShop2 :: ' . $this->modx->lexicon('ms2_settings');
    }


    /**
     * @return array
     */
    public function getLanguageTopics()
    {
        return array('minishop2:default', 'minishop2:product', 'minishop2:manager');
    }


    /**
     *
     */
    public function loadCustomCssJs()
    {
        $this->addCss($this->miniShop2->config['cssUrl'] . 'mgr/main.css');
        $this->addJavascript($this->miniShop2->config['jsUrl'] . 'mgr/minishop2.js');
        $this->addJavascript($this->miniShop2->config['jsUrl'] . 'mgr/misc/ms2.utils.js');
        $this->addJavascript($this->miniShop2->config['jsUrl'] . 'mgr/misc/ms2.combo.js');
        $this->addJavascript($this->miniShop2->config['jsUrl'] . 'mgr/settings/delivery.grid.js');
        $this->addJavascript($this->miniShop2->config['jsUrl'] . 'mgr/settings/payment.grid.js');
        $this->addJavascript($this->miniShop2->config['jsUrl'] . 'mgr/settings/status.grid.js');
        $this->addJavascript($this->miniShop2->config['jsUrl'] . 'mgr/settings/vendor.grid.js');
        $this->addJavascript($this->miniShop2->config['jsUrl'] . 'mgr/settings/link.grid.js');
        $this->addJavascript($this->miniShop2->config['jsUrl'] . 'mgr/settings/category.tree.js');
        $this->addJavascript($this->miniShop2->config['jsUrl'] . 'mgr/settings/option.grid.js');
        $this->addJavascript($this->miniShop2->config['jsUrl'] . 'mgr/settings/settings.panel.js');
        $this->addJavascript(MODX_MANAGER_URL . 'assets/modext/util/datetime.js');

        $types = $this->miniShop2->loadOptionTypeList();
        foreach ($types as $type) {
            $className = $this->miniShop2->loadOptionType($type);
            if (class_exists($className)) {
                /** @var msOptionType $className */
                if ($className::$script) {
                    $this->addJavascript($this->miniShop2->config['jsUrl'] . 'mgr/settings/types/' . $className::$script);
                }
            }
        }

        $config = $this->miniShop2->config;
        $this->addHtml('<script type="text/javascript">
            miniShop2.config = ' . json_encode($config) . ';
            Ext.onReady(function() {
                MODx.add({xtype: "minishop2-panel-settings"});
            });
        </script>');

        $this->modx->invokeEvent('msOnManagerCustomCssJs', array(
            'controller' => &$this,
            'page' => 'settings',
        ));
    }
}