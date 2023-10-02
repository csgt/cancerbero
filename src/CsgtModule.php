<?php
namespace Csgt\Cancerbero;

class CsgtModule
{
    const REPORT = ['index', 'store'];
    const INDEX  = ['index'];
    const ALL    = ['index', 'create', 'store', 'edit', 'update', 'destroy', 'data', 'detail'];

    public $name           = null;
    public $description    = null;
    public $module         = null;
    public $menuOrder      = 0;
    public $permissions    = self::ALL;
    public $icon           = null;
    public $parentModule   = null;
    public $menuPermission = 'index';

    public function __construct($aName, $aDescription, $aModule, $aMenuOrder, $aIcon = null, $aParentModule = null, $aPermissions = self::ALL, $aMenuPermission = 'index')
    {
        $this->name           = $aName;
        $this->description    = $aDescription;
        $this->module         = $aModule;
        $this->menuOrder      = $aMenuOrder;
        $this->permissions    = $aPermissions;
        $this->icon           = $aIcon;
        $this->parentModule   = $aParentModule;
        $this->menuPermission = $aMenuPermission;
    }
}
