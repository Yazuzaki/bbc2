<?php

class bud_model extends CI_Model
{


    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }

    public function user_registration()
    {
        $password = $this->input->post('password');
        $con_password = $this->input->post('con_password');
        $email = $this->input->post('email');

        // Check if the email is already in use
        $this->db->where('email', $email);
        $existing_user = $this->db->get('users')->row();

        if ($existing_user) {
            $this->session->set_flashdata('error', 'This email is already in use.');
            redirect('page/register');
        } elseif ($password != $con_password) {
            $this->session->set_flashdata('error', 'The passwords do not match.');
            redirect('page/register');
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $data = array(
                "name" => $this->input->post('name'),
                "email" => $email,
                "password" => $hashed_password // Store the hashed password
            );

            $this->db->insert('users', $data);
            $this->session->set_flashdata('success', 'Registered successfully.');
            redirect('page/loginview');
        }
    }



    public function login_user()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $this->db->where('email', $email);
        $this->db->where('password', $password);
        $query = $this->db->get('users');
        $find_user = $query->num_rows();

        if ($find_user > 0) {
            $user_data = array(
                'email' => $email,
                'logged_in' => TRUE
            );

            $this->session->set_userdata($user_data);
            $this->session->set_flashdata('suc', 'Logged in successfully.');
            redirect('Page/main');
        } else {
            $this->session->set_flashdata('error', 'Incorrect Authentication');
            redirect('page/loginview');
        }



    }
    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('logged_in');
        $this->session->set_flashdata('suc', 'Logged out successfully.');
        redirect('page/loginview');
    }

    public function is_reserved($datetime)
    {
        $this->db->where('reserved_datetime', $datetime);
        $query = $this->db->get('reservations');

        return $query->num_rows() > 0;
    }

    public function getReservations()
    {
        return $this->db->get('today')->result();
    }

    public function get_all_reservations()
    {
        return $this->db->get('reservations')->result();
    }
    public function get_all_declined()
    {
        return $this->db->get('declined')->result();
    }

    public function get_all_approved()
    {
        return $this->db->get('today')->result();
    }



    public function get_a_reservations()
    {
        $query = $this->db->select('id, reserved_datetime, created_at')
            ->from('reservations')
            ->where('status', 'approved')
            ->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return array();
    }
    public function getReservationsForDate($date)
    {
        $this->db->select('DATE_FORMAT(reserved_datetime, "%H:%i") as time');
        $this->db->where('DATE(reserved_datetime)', $date);
        $query = $this->db->get('today');
        return $query->result_array();
    }
    public function get_all_events()
    {
        $query = $this->db->get('reservations');
        $events = $query->result();
        return $events;
    }
    public function updateStatus($reservationId, $newStatus)
    {
        $data = array(
            'status' => $newStatus
        );

        $this->db->where('id', $reservationId);
        $this->db->update('reservations', $data);
    }

    public function getReservation($reservationId)
    {
        $this->db->where('id', $reservationId);
        return $this->db->get('reservations')->row();
    }

    public function transferToToday($reservation)
    {
        $data = array(
            'reserved_datetime' => $reservation->reserved_datetime,
            'created_at' => $reservation->created_at,
            'court' => $reservation->court,
            'sport' => $reservation->sport
        );
        $this->db->insert('today', $data);
    }

    public function removeReservation($reservationId)
    {
        $this->db->where('id', $reservationId);
        $this->db->delete('reservations');
    }
    public function updateTodayStatus($reservedDatetime, $status)
    {
        $this->db->where('reserved_datetime', $reservedDatetime);
        $data = array('status' => $status);
        $this->db->update('today', $data);
    }

    public function transferTodeclined($reservation)
    {
        $data = array(
            'reserved_datetime' => $reservation->reserved_datetime,
            'created_at' => $reservation->created_at,
            'court' => $reservation->court,
            'sport' => $reservation->sport,
        );
        $this->db->insert('declined', $data);
    }
    public function updateDeclinedStatus($reservedDatetime, $status)
    {
        $this->db->where('reserved_datetime', $reservedDatetime);
        $data = array('status' => $status);
        $this->db->update('declined', $data);
    }
    public function get_reservations_by_date_range($start_date, $end_date)
    {
        $formatted_start_date = $start_date->format('Y-m-d 00:00:00');
        $formatted_end_date = $end_date->format('Y-m-d 23:59:59');

        $this->db->where('reserved_datetime >=', $formatted_start_date);
        $this->db->where('reserved_datetime <=', $formatted_end_date);
        $query = $this->db->get('reservations');

        return $query->result();
    }

    public function getCourtNumberById($courtId)
    {
        $query = $this->db->get_where('courts', array('court_number' => $courtId));

        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->court_number;
        } else {
            return null;
        }
    }
    public function getSportNameById($sportId)
    {
        $query = $this->db->get_where('sports', array('sport_id' => $sportId));

        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->sport_name;
        } else {
            return null;
        }
    }
    public function get_reservation($reservation_id)
    {
        $query = $this->db->get_where('reservations', array('id' => $reservation_id));
        return $query->row();
    }

    public function update_reservation($reservation_id, $data)
    {
        $this->db->where('id', $reservation_id);
        $this->db->update('reservations', $data);
    }
    public function get_reservation_by_id($reservationId)
    {
        $query = $this->db->get_where('reservations', array('id' => $reservationId));
        return $query->row();
    }
    public function getTodayReservations()
    {
        // Fetch data from the 'today' table
        $query = $this->db->get('today');
        return $query->result();
    }
    
    public function insert_future_reservation($reservationData)
    {
        $this->db->insert('future', $reservationData);
    }
    public function insert_ongoing_reservation($reservationData)
    {
        // Insert the reservation data into the "Ongoing" table
        $this->db->insert('ongoing', $reservationData);
    }

}