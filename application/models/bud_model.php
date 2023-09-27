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
    public function get_all_canceled_reservations()
    {
        return $this->db->get('canceled')->result();
    }
    public function get_all_reservations_ongoing()
    {
        return $this->db->get('ongoing')->result();
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
        $reservation = $this->db->get('reservations')->row();

        if ($reservation) {
            $reservation->popoverHtml = 'Reservation Details:<br>' .
                'Date: ' . date('Y-m-d', strtotime($reservation->reserved_datetime)) . '<br>' .
                'Time: ' . date('H:i', strtotime($reservation->reserved_datetime)) . '<br>' .
                'Court: ' . $reservation->court . '<br>' .
                'Sport: ' . $reservation->sport;
        }

        return $reservation;
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
    public function get_reservations_by_date_range_ongoing($start_date, $end_date)
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


    public function transferToOngoing($reservation)
    {
        $data = array(
            'reserved_datetime' => $reservation->reserved_datetime,
            'created_at' => date('Y-m-d H:i:s'),
            'court' => $reservation->court,
            'sport' => $reservation->sport,
            'status' => 'ongoing'
        );
        $this->db->insert('ongoing', $data);
    }

    public function transferToFuture($reservation)
    {
        $data = array(
            'reserved_datetime' => $reservation->reserved_datetime,
            'created_at' => date('Y-m-d H:i:s'),
            'court' => $reservation->court,
            'sport' => $reservation->sport,
            'status' => 'approved'
        );
        $this->db->insert('future', $data);
    }
    public function getOngoingReservations($dateRange = null)
    {


        $this->db->where('status', 'ongoing');
        if ($dateRange) {
            $this->db->where('start_date <=', $dateRange['end_date']);
            $this->db->where('end_date >=', $dateRange['start_date']);
        }
        $query = $this->db->get('ongoing'); // Assuming 'ongoing' is your database table name
        return $query->result();
    }
    public function getFutureReservations()
    {
        $query = $this->db->get('future');
        return $query->result();
    }
    public function cancel_and_move_reservation($reservationId)
    {
        $this->load->database();

        // Get reservation data from 'ongoing' table
        $reservation_data = $this->db->get_where('future', array('id' => $reservationId))->row_array();

        if (!$reservation_data) {
            // Reservation not found, return false or handle the error as needed.
            return false;
        }

        // Remove the 'id' key from the reservation data
        unset($reservation_data['id']);

        $reservation_data['status'] = 'canceled';

        $this->db->insert('canceled', $reservation_data);

        // Check if the insertion was successful
        if ($this->db->affected_rows() > 0) {
            // Delete the reservation from the 'ongoing' table
            $this->db->where('id', $reservationId);
            $this->db->delete('future');

            return true;
        }

        return false;
    }
    public function updateReservation($reservationId, $newReservedDatetime, $newCourt, $newSport)
    {
        $data = array(
            'reserved_datetime' => $newReservedDatetime,
            'court' => $newCourt,
            'sport' => $newSport
        );

        $this->db->where('id', $reservationId);
        $this->db->update('future', $data);

        return $this->db->affected_rows() > 0;
    }

    public function updateReservation_for_reservation($reservationId, $newReservedDatetime, $newCourt, $newSport)
    {
        $data = array(
            'reserved_datetime' => $newReservedDatetime,
            'court' => $newCourt,
            'sport' => $newSport
        );

        $this->db->where('id', $reservationId);
        $this->db->update('reservations', $data);

        return $this->db->affected_rows() > 0;
    }
    public function checkCourtSportAvailability($court, $sport, $date, $time)
    {
        // Check if there are any reservations for the specified court, sport, date, and time
        $query = $this->db->query("SELECT COUNT(*) as count FROM today WHERE court = ? AND sport = ? AND reserved_datetime = ?", array($court, $sport, $date . ' ' . $time));

        $result = $query->row_array();

        // Retrieve the list of times for reservations on the specified date
        $this->db->select('DATE_FORMAT(reserved_datetime, "%H:%i") as time');
        $this->db->where('DATE(reserved_datetime)', $date);
        $query = $this->db->get('today');
        $times = $query->result_array();

        // Create a response array to return both availability status and times
        $response = array(
            'availability' => ($result['count'] > 0) ? false : true,
            'times' => $times
        );

        return $response;
    }

    public function moveReservationsToOngoing($currentDate)
    {
        // Query to move reservations
        $sql = "INSERT INTO ongoing (reserved_datetime, created_at, court, sport)
                SELECT reserved_datetime, created_at, court, sport
                FROM future
                WHERE DATE(reserved_datetime) = ?";

        $this->db->query($sql, array($currentDate));

        // Check if reservations were moved
        if ($this->db->affected_rows() > 0) {
            // Delete the moved reservations from the future table
            $this->db->query("DELETE FROM future WHERE DATE(reserved_datetime) = ?", array($currentDate));

            return true; // Reservations moved successfully
        } else {
            return false; // Failed to move reservations
        }
    }
    public function getAllReservations()
    {
        $query = $this->db->get('reservations');


        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
    public function getReservationsWithinTimeFrame($court, $sport, $date, $startTime, $endTime)
    {
        // Calculate the end time to be one hour ahead of the selected time
        $endHour = date('H', strtotime($startTime)) + 1;
        $endTime = date('Y-m-d H:i:s', strtotime("$date $endHour:00:00"));

        // Query to retrieve reservations within the specified time frame
        $this->db->select('*');
        $this->db->from('today');
        $this->db->where('court', $court);
        $this->db->where('sport', $sport);
        $this->db->where('reserved_datetime >=', date('Y-m-d H:i:s', strtotime($startTime)));
        $this->db->where('reserved_datetime <', $endTime);

        // Execute the query and return the results as an array
        $query = $this->db->get();

        return $query->result_array();
    }
    public function finalReservation($reservationId, $modifiedData)
    {
        $data = array(
            'status' => $modifiedData->status,
            'sport' => $modifiedData->sport,
            'court' => $modifiedData->court,
        );

        $this->db->where('id', $reservationId);
        return $this->db->update('reservations', $data);
    }
    public function get_reservations()
    {

        $query = $this->db->get('reservations');
        return $query->result();
    }
    public function getReservationsForDateTime($date, $time)
    {
        // Adjust the table and column names as per your database schema
        $this->db->where('reserved_datetime', $date . ' ' . $time);
        return $this->db->get('today')->result();
    }
    public function get_all_courts()
    {
        $query = $this->db->get('courts');
        return $query->result(); // Return the result as an array of objects
    }


}