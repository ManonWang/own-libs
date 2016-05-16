<?php 

namespace Home\Model;

class TrackModel extends BaseModel {

    public function getTrackStat($data) {
        $conds = array('status' => 1);
        if (!empty($data['start_time'])) {
            $conds['track_time'][] = array("egt", $data['start_time']);
        }
        if (!empty($data['end_time'])) {
            $conds['track_time'][] = array("elt", $data['end_time']);
        }
        if (!empty($data['track_dept'])) {
            $conds['track_dept'] = array('IN', $data['track_dept']);
        }
        return $this->getPagedList($conds, 'id DESC');
    }

}
