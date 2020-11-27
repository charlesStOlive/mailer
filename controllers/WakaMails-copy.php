<?php namespace Waka\Mailer\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use System\Classes\SettingsManager;

/**
 * WakaMails Back-end Controller
 */
class WakaMails extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.ReorderController',
        'Waka.Informer.Behaviors.PopupInfo',
        'Waka.Mailer.Behaviors.MailBehavior',
        'Waka.Utils.Behaviors.DuplicateModel',
        'waka.Utils.Behaviors.SideBarAttributesBehavior',
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $sidebarAttributesConfig = 'config_attributes.yaml';
    public $reorderConfig = 'config_reorder.yaml';
    public $duplicateConfig = 'config_duplicate.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('October.System', 'system', 'settings');
        SettingsManager::setContext('Waka.Mailer', 'wakamails');

    }
    public function update($id)
    {
        $this->bodyClass = 'compact-container';
        return $this->asExtension('FormController')->update($id);
    }

    public function update_onSave($recordId = null)
    {
        $this->asExtension('FormController')->update_onSave($recordId);
        return [
            '#sidebar_attributes' => $this->attributesRender($this->params[0]),
        ];
    }
}