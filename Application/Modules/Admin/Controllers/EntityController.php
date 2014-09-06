<?php namespace Application\Modules\Admin\Controllers;

use \Black\Config;

class EntityController extends \Black\Controller
{
    protected $entitiesConfig;

    public function init()
    {
        $this->entitiesConfig = Config::get('entities');
    }

    public function indexAction($entityName = null)
    {
        $this->view->layout = Config::$paths['application'] . '/Modules/Admin/Views/Layouts/base.phtml';

        $entityName = !empty($entityName) ? strtolower($entityName) : 'news';
        if (!isset($this->entitiesConfig[$entityName])) {
            throw new \RunTimeException("No configuration for entity: {$entityName}");
        }
        $entityConfig = $this->entitiesConfig[$entityName];
        $table = isset($entityConfig->table) ? $entityConfig->table : $entityName;

        //@todo Improve all this
        include(Config::$paths['base'] . '/Lib/xcrud/xcrud.php');
        $xcrud = \Xcrud::get_instance();
        $conf = Config::get('application')->database;

        $xcrud->connection(
            $conf->user,
            $conf->password,
            $conf->databaseName,
            $conf->host,
            'utf8'
        );

        $xcrud->table($table);
        $xcrud->limit(20);
        $xcrud->order_by('id', 'desc');
        $xcrud->unset_print();
        $xcrud->unset_csv();
        $xcrud->show_primary_ai_column(false);
        $xcrud->limit_list(['50','100','500','all']);

        if (!empty($entityConfig->fields)) {
            $fieldsInDetails = [];
            $columnsInGrid = [];
            foreach ($entityConfig->fields as $fieldName => $field) {
                if (!empty($field->no_editor)) {
                    $xcrud->no_editor($fieldName);
                }

                if (!empty($field->type)) {
                    $default = !empty($field->default) ? $field->default : false;
                    $attribs = !empty($field->options) ? $field->options : [];
                    $xcrud->change_type($fieldName, $field->type, $default, $attribs);
                }

                $fieldsInDetails[] = $fieldName;
                if (empty($field->hideInBrowse)) {
                    $columnsInGrid[] = $fieldName;
                }
            }
            $xcrud->fields($fieldsInDetails);
            $xcrud->columns($columnsInGrid);
        }


        $this->view->xcrud = $xcrud;

        $entitesMenu = [];
        foreach ($this->entitiesConfig as $entityName => $entity) {
            $entitesMenu[$entityName] = isset($entity->displayAs) ? $entity->displayAs : $entityName;
        }
        $this->view->entitesMenu = $entitesMenu;

    }
}
