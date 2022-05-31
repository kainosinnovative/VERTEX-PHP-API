<?php

/**
 * All common DB-connection functions will be written here
 *
 *
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Dealer_model extends CI_Model
{
    /**
     * To get dealer profile data
     *
     * @param int $dealerId
     * @return array dealer details
     */
    public function getProfile($dealerId)
    {
        /* return $this->db->select('*')
        ->get_where('dealer', array('dealer_id' => $dealerId))
        ->row_array(); */
        $this->db->select('d.*, b.brand_name');
        $this->db->from('dealer d');
        $this->db->join('brand b', 'b.brand_id=d.brand', 'left');
        $this->db->where('dealer_id', $dealerId);
        return $this->db->get()->row_array();
    }

    public function getLeadList()
    {
        return $this->db->select('DISTINCT (lead_id), full_name')->where('full_name IS NOT NULL')->get('zoho_leads')->result_array();
    }

    public function insertNotes($note_data)
    {
        $this->db->insert('dealers_note', $note_data);
        $insert_id = $this->db->insert_id();
        return $insert_id ? "success" : "fail";
    }

    public function updateNotes($note_data)
    {
        $this->db->where('notes_id', $note_data['notes_id']);
        $this->db->update('dealers_note', $note_data);
        return 'updated';
    }

    public function getDealerNotes($dealer_id)
    {
        return $this->db->get_where('dealers_note', array('dealer_id' => $dealer_id))->result_array();
    }

    public function deleteNotes($note_id, $dealerId)
    {
        $where = ['notes_id' => $note_id, 'dealer_id' => $dealerId];
        $this->db->where($where);
        $this->db->delete('dealers_note');
        return "deleted";
    }

    public function getVariantDetails($variant)
    {
        $this->db->select('f.fuel_type, v.tramission_type');
        $this->db->from('variant v');
        $this->db->join('fuel_type f', 'f.fuel_type_id = v.fuel_type and f.status = 1');
        //$this->db->join('transmission_type tt', 'tt.transmission_id = v.tramission_type and tt.status = 1', 'left');
        $this->db->where('v.status', 1);
        $this->db->where('pro_name', $variant);
        return $this->db->get()->row_array();
    }

    public function getDealerData($fields, $dealer_id, $join = '')
    {
        $this->db->select($fields);
        $this->db->from('dealer d');
        ($join == 'test_drive_car_owners') ? $this->db->join('test_drive_car_owners td', 'td.owner_phone = d.contact_no') : '';
        $this->db->where('d.dealer_id', $dealer_id);
        return $this->db->get()->row_array();
    }

    public function getTestDriveCarOwner($fields, $where)
    {
        return $this->db->select($fields)->where($where)->get('test_drive_car_owners')->row_array();
    }

    public function checkTestDriveCar($where, $test_drive_id = '')
    {

        $this->db->select('*');
        $this->db->where($where);
        $test_drive_id ? $this->db->where('id !=', $test_drive_id) : '';
        return $this->db->get('test_drive_cars_details')->row_array();
    }

    public function getTestDriveCarList($dealer_id)
    {

        $dealer_data = $this->getDealerData('contact_no, dealer_name, owner_id', $dealer_id, 'test_drive_car_owners');
        //$test_car_owner = $this->getTestDriveCarOwner('owner_id', array('owner_phone' => $dealer_data['contact_no']));
        $dealer_name = $dealer_data['dealer_name'];
        $this->db->select("id, person_name, contact_number, status, car_full_name, lant, long, '$dealer_name' as dealer_name, year, address, brand_model, varaint, registeration_no");
        $this->db->where('owner_id', $dealer_data['owner_id']);
        return $this->db->get('test_drive_cars_details')->result_array();
    }

    public function createTestDriveCar($test_car_data, $dealer_id)
    {
        $this->db->insert('test_drive_cars_details', $test_car_data);
        $insert_id = $this->db->insert_id();
        return $insert_id ? "success" : "fail";
    }

    public function editTestDriveCar($test_car_data, $dealer_id)
    {
        $where = array('id' => $test_car_data['id'], 'owner_id' => $test_car_data['owner_id']);
        $this->db->where($where);
        $this->db->update('test_drive_cars_details', $test_car_data);
        return "updated";
    }

    public function deleteTestDriveCar($test_drive_id, $dealer_id)
    {
        $dealer_data = $this->getDealerData('owner_id', $dealer_id, 'test_drive_car_owners');
        $where = ['id' => $test_drive_id, 'owner_id' => $dealer_data['owner_id']];
        $this->db->where($where);
        $this->db->delete('test_drive_cars_details');
        return "deleted";
    }

    public function getShowRoomInformation($dealer_id)
    {
        $this->db->select('dsl_id, person_name,mobile_number,location,status');
        $this->db->where('dealer_id', $dealer_id);
        return $this->db->get('dealer_showroom_location')->result_array();
    }

    public function insertShowroom($showroomData)
    {
        $this->db->insert('dealer_showroom_location', $showroomData);
        $showroom_id = $this->db->insert_id();
        return $showroom_id ? "success" : "failed";
    }

    public function updateShowroom($showroomData)
    {
        $this->db->where('dsl_id', $showroomData['dsl_id']);
        $this->db->update('dealer_showroom_location', $showroomData);
        return "updated";
    }

    public function deleteShowroom($showroom_id, $dealer_id)
    {
        $where = ['dsl_id' => $showroom_id, 'dealer_id' => $dealer_id];
        $this->db->where($where);
        $this->db->delete('dealer_showroom_location');
        return "deleted";
    }

    public function getAttachmentData($dealer_id)
    {
        $baseUrl = base_url();
        return $this->db->select("*, IF(attached_path = ' ', attached_path, concat('$baseUrl',attached_path)) as attached_path1")->get_where('new_dealer_attachment', array('dealer_id' => $dealer_id))->result_array();
    }

    public function getData($tablename, $fields, $where = '', $type = '')
    {
        $this->db->select($fields);
        $where ? $this->db->where($where) : '';
        return $type ? $this->db->get($tablename)->row_array() : $this->db->get($tablename)->result_array();
    }

    public function insertData($data, $tablename)
    {
        $this->db->insert($tablename, $data);
        $showroom_id = $this->db->insert_id();
        return $showroom_id ? "success" : "failed";
    }

    public function updateData($data, $tablename, $where)
    {
        $this->db->where($where);
        $this->db->update($tablename, $data);
        return "updated";
    }

    public function deleteData($tablename, $where)
    {
        $this->db->where($where);
        $this->db->delete($tablename);
        return "deleted";
    }

}
