<?php 

namespace Home\Model;

class RiskSummaryModel extends BaseModel {
    
    private $relationData   = array();
    private $dictionaryData = array();

    public function setDictionaryData($data) {
        foreach ($data as $type) {
            foreach ($type as $item) {
                $this->dictionaryData[$item['id']] = $item;
            }
        }
    }

    public function getTreeData($data) {
        $this->setDictionaryData($data);

        $summary = $this->getList(array('status' => 1));
        foreach ($summary as $item) {
            $catPath = $this->getCatPath($item);
            $this->add2RelationData($this->relationData, $catPath);
        }

        return $this->genTreeData($this->relationData);
    }
    
    public function getCatPath($item) {
        $catPath = array();
        foreach (array('type', 'level', 'cat1', 'cat2', 'cat3') as $field) {
            if ($item[$field] <= 0) {
                break;
            } else {
                $catPath[] = $item[$field];
            }
        }
        $catPath[] = $item['cid'];
        return $catPath;
    }

    public function add2RelationData(&$relation, $catPath) {
        $category = array_shift($catPath);
        if (empty($catPath)) {
            $relation[] = $category;
        } else {
            !isset($relation[$category]) && $relation[$category] = array();
            $this->add2RelationData($relation[$category], $catPath);
        }
    }

    public function genTreeData($relationData) {
        $return = array();
        foreach ($relationData as $key => $val) {
            if (is_array($val)) {
                $node = $this->getNode($key);
                $node['nodes'] = $this->genTreeData($val);
                $return[] = $node;
            } else {
                $return[] = $this->getNode($val);
            }
        }
        return $return;
    }

    public function getNode($did) {
        return array("text" => $this->dictionaryData[$did]['name'], 'tags' => array('did' => $did), 'state' => array('expanded' => false));
    }


}

