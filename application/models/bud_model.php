<?php

class bud_model extends CI_Model
{


    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }

    public function register_user($data) {
        // Insert the user data into the database
        return $this->db->insert('users', $data);
    }

    public function check_email_exist($email) {
        // Check if the email already exists in the database
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        return $query->num_rows() > 0;
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
            'user_email'=> $reservation->user_email,
            'user_name' => $reservation->user_name,
            'image' => $reservation->image,
            'hours' => $reservation->hours,
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
            'user_email'=> $reservation->user_email,
            'user_name' => $reservation->user_name,
            'image' => $reservation->image,
            'hours'=> $reservation->hours,
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
        $query = $this->db->get('ongoing'); 
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
       
        $this->db->where('reserved_datetime', $date . ' ' . $time);
        return $this->db->get('today')->result();
    }
    public function get_all_courts()
    {
        $query = $this->db->get('courts');
        return $query->result(); 
    }
    public function update_status($court_id, $new_status)
    {
        // Update the court status in the database based on $court_id
        $data = array('status' => $new_status);
        $this->db->where('id', $court_id);
        $this->db->update('courts', $data);
    }
    public function add_court($data)
    {
        // Insert a new court into the database
        $this->db->insert('courts', $data);
    }
    public function create($data)
    {
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }

    public function get_by_email($email)
    {
        return $this->db->get_where('users', ['email' => $email])->row_array();
    }

    public function is_admin($user_id)
    {
        return $this->db->get_where('users', ['id' => $user_id, 'role' => 'admin'])->row() !== null;
    }
    public function create_with_verification_token($data) {
        $data['email_verification_token'] = bin2hex(random_bytes(32)); // Generate a unique token
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }

    public function verify_email($token) {
        $this->db->set('email_verified', 1);
        $this->db->where('email_verification_token', $token);
        return $this->db->update('users');
    }
    public function validate_user($email, $password)
    {
        // Validate user's credentials against the database
        $query = $this->db->get_where('users', array('email' => $email, 'password' => md5($password)));

        if ($query->num_rows() === 1) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function get_user_by_id($user_id)
    {
        // Retrieve user data by user ID
        $query = $this->db->get_where('users', array('id' => $user_id));

        if ($query->num_rows() === 1) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function get_user_by_email($email) {
        // Query the database to retrieve user data based on email
        return $this->db->get_where('users', ['email' => $email])->row();
    }
    public function determineUserRole($email) {
        $user = $this->db->where('email', $email)->get('users')->row();

        if ($user && $user->role === 'admin') {
            return 'admin';
        } else {
            return 'user';
        }
    }
    public function index($email,$password){
        $data=array(
        'email'=>$email,
        'password'=>$password);
        $query=$this->db->where($data);
        $login=$this->db->get('users');
         if($login!=NULL){
        return $login->row();
         }  
        }
        protected $table = 'courts'; 

        public function get_all_courtss() {
            return $this->db->get($this->table)->result();
        }
    
        public function update_court_status($court_id, $new_status) {
            // Update the status in the 'courts' table
            $data = array('status' => $new_status);
            $this->db->where('court_id', $court_id);
            $this->db->update('courts', $data);
        
            // Check if the update was successful
            return $this->db->affected_rows() > 0;
        }
        
    
        public function get_distinct_status_options() {
            $this->db->distinct()->select('status');
            $query = $this->db->get($this->table);
    
            $status_options = [];
            foreach ($query->result() as $row) {
                $status_options[] = $row->status;
            }
    
            return $status_options;
        }
        public function get_court_choices() {
            
            $query = $this->db->select('status')->from('courts')->get();
    
           
            return $query->result();
        }
        public function insert_image($data) {
            $this->db->insert('reservations', $data);
        }

     

    public function getUsers() {
        $query = $this->db->get('users');
        return $query->result(); 
    }

    public function getBlockedTimes() {
        $this->db->select('*');
        $this->db->from('blocked_times');
        $query = $this->db->get();
        return $query->result(); 
    }

    public function getUserByVerificationCode($verificationCode) {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('email_verification_token', $verificationCode);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }
    public function getReservationqr($reservationId) {
       
        $this->db->where('id', $reservationId);
        $query = $this->db->get('reservations');

        // Check if a reservation with the given ID exists
        if ($query->num_rows() == 1) {
            // Return the reservation data as an object
            return $query->row();
        } else {
            // Reservation not found
            return null;
        }
    }
    public function getQRCodeDataURI($reservation_id) {
        
        $query = $this->db->select('qr_code')->where('id', $reservation_id)->get('reservations');

        if ($query->num_rows() > 0) {
            $result = $query->row();
            return $result->qr_code;
        }

        return null;
    }
    public function create_reservation($data) {
        // Insert the data into the 'reservations' table
        return $this->db->insert('reservations', $data);
    }
    public function getUserData($userId) {
        // Define the database table name
        $table = 'users';
        
     
        $this->db->select('name, email, password'); 
        $this->db->from($table);
        $this->db->where('id', $userId); 
        $query = $this->db->get();
        
        
        if ($query->num_rows() > 0) {
            
            return $query->row_array();
        } else {
            
            return false;
        }
    }
    public function getUserByQRCodeSecret($qrCodeSecret) {
        $this->db->where('qr_code_secret', $qrCodeSecret);
        $query = $this->db->get('users');
        
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }
    public function get_data_by_unique_combination($unique_combination) {
        $this->db->where('qr_code_secret', $unique_combination);
        $query = $this->db->get('users');
        return $query->row_array();
    }
    public function get_user_by_username($username) {
        return $this->db->get_where('users2', array('username' => $username))->row();
    }
    
}

        
