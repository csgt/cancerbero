<?php
namespace Csgt\Cancerbero;

class CsgtModule
{
    const REPORT = [1, 3];
    const INDEX  = [1];
    const ALL    = [1, 2, 3, 4, 5, 6, 7, 8];

    public $name           = null;
    public $description    = null;
    public $module         = null;
    public $menuOrder      = 0;
    public $permissions    = self::ALL;
    public $icon           = null;
    public $parentModule   = null;
    public $menuPermission = 1;

    public function __construct($aName, $aDescription, $aModule, $aMenuOrder, $aIcon = null, $aParentModule = null, $aPermissions = self::ALL, $aMenuPermission = 1)
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
