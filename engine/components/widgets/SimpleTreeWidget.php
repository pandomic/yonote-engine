<?php
class SimpleTreeWidget extends CWidget
{
    public $tree = array();

    public function run()
    {
        echo $this->_renderTree($this->tree);
    }
    
    private function _renderVertex($item,$subItems = null)
    {
        return $this->renderPartial('vertex',array(
            'item' => $item,
            'subitems' => $subItems
        ),true);
    }

    private function _renderEdge($edge)
    {
        return $this->renderPartial('edge',array(
            'edge' => $edge
        ),true);
    }

    private function _renderTree($params)
    {
        $tree = '';
        foreach ($params as $treeEdge)
        {
            $subItems = null;
            if (isset($treeEdge['subitems']))
                if (is_array($treeEdge['subitems']))
                {
                    $subItems = $this->_renderTree($params);
                    $tree .= $this->_renderVertex($treeEdge['text'],$subItems);
                }
            else
                $tree .= $this->_renderVertex($treeEdge['text']);
        }
        return $this->_renderEdge($tree);
    }
}
?>