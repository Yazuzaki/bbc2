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
   
    public function getReservationDetails($reservationId) {
        // Implement your logic to retrieve reservation details from the database based on the $reservationId.
        // Replace the following line with your actual database query.
        $query = $this->db->get_where('reservations', array('id' => $reservationId));
        
        // Assuming you have a 'reservations' table with fields such as 'id', 'reserved_datetime', 'status', etc.

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false; // Reservation not found
        }
    }
    public function generateRandomQRCode($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomQRCode = '';

        for ($i = 0; $i < $length; $i++) {
            $randomQRCode .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomQRCode;
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
    public function calculate_fee($reservation_id) {
        $this->db->select('courts.price * ongoing.hours AS total_fee');
        $this->db->from('courts');
        $this->db->join('ongoing', 'courts.court_number = ongoing.court');
        $this->db->where('ongoing.id', $reservation_id);
    
        $query = $this->db->get();
        $result = $query->row();
    
        return $result ? $result->total_fee : 0;
    }
    public function getrepReservations() {
        $query = $this->db->query("SELECT COUNT(*) as count FROM reservations");
        $result = $query->row();
        return $result->count;
    }
    public function getReservationDetailsByQRCode($reservationQRCode) {
        $query = $this->db->get_where('reservations', array('qr_code' => $reservationQRCode));
        return $query->row();
    }
    public function get_qr_code_data() {
        $query = $this->db->get('qr_code_data');
        return $query->result();
    }

    public function getSportFrequency() {
        $this->db->select('sport, COUNT(*) as frequency');
        $this->db->group_by('sport');
        $query = $this->db->get('today');

        return $query->result();
    }
    public function getReservationCount() {
        $this->db->select('sport, COUNT(*) as frequency');
        $this->db->from('today'); 
        $this->db->where('status', 'approved'); 
        $this->db->group_by('sport');
        $query = $this->db->get();

        return $query->result();
    }
    public function get_user_by_verification_token($token)
    {
        $query = $this->db->get_where('users', array('email_verification_token' => $token), 1);
        return $query->row_array();
    }
    public function get_user_by_verification($verificationToken) {
        $query = $this->db->get_where('users', array('email_verification_token' => $verificationToken));
        return $query->row();
      
    }
    
    public function update_email_verification_status($userId, $status)
    {
        $this->db->where('id', $userId);
        $this->db->update('users', array('email_verified' => $status));
    }
    public function get_timeslots() {
        $query = $this->db->get('timeslots');
        return $query->result();
    }
    public function getAvailableCourts() {
        $query = $this->db->get_where('courts', array('status' => 'available'));
        return $query->result_array();
    }
    public function getCanceledCount() {
        $query = $this->db->query("SELECT COUNT(*) as count FROM canceled");
        $result = $query->row();
        return $result->count;
    }

    public function getDeclinedCount() {
        $query = $this->db->query("SELECT COUNT(*) as count FROM declined");
        $result = $query->row();
        return $result->count;
    }
    public function getFutureCount() {
        $query = $this->db->query("SELECT COUNT(*) as count FROM future");
        $result = $query->row();
        return $result->count;
    }
    public function getpendingCount() {
        $query = $this->db->query("SELECT COUNT(*) as count FROM reservations");
        $result = $query->row();
        return $result->count;
    }
    public function insert_reference_number($reference_number) {
        // Insert the reference number into the database
        $data = array(
            'referencenumber' => $reference_number
        );

        $this->db->insert('refnum', $data);
    }
    public function cancelReservation($reservationId)
    {
        // Get reservation details
        $reservation = $this->db
            ->where('id', $reservationId)
            ->get('future')
            ->row();

        // Check if cancellation is allowed (2 days before the reservation)
        $reservationDate = new DateTime($reservation->reserved_datetime);
        $currentDate = new DateTime();
        $difference = $currentDate->diff($reservationDate);

        if ($difference->days >= 2) {
            // Insert canceled reservation into the 'canceled' table
            $canceledData = array(
                'reserved_datetime' => $reservation->reserved_datetime,
                'created_at' => $reservation->created_at,
                'court' => $reservation->court,
                'sport' => $reservation->sport,
                'status' => 'canceled',
                'date_of_cancellation' => date('Y-m-d H:i:s'),
                'user_name' => $reservation->user_name,
                'user_email' => $reservation->user_email,
                'image' => $reservation->image,
                'qr_code' => $reservation->qr_code,
                'hours' => $reservation->hours,
            );

            $this->db->insert('canceled', $canceledData);

            // Delete the reservation from the 'future' table
            $this->db->where('id', $reservationId)->delete('future');

            return true; // Cancellation successful
        }

        return false; // Cancellation not allowed
    }
    public function getUserReservations($userId)
    {
        // Assuming 'reservations' is the name of your table
        $this->db->where('id', $userId);
        $query = $this->db->get('reservations');

        // Check if there are any reservations
        if ($query->num_rows() > 0) {
            return $query->result(); // Return an array of reservation objects
        } else {
            return array(); // Return an empty array if there are no reservations
        }
    }
    public function addAvailability($courtId, $availableDatetime) {
        $data = array(
            'court_id' => $courtId,
            'available_datetime' => $availableDatetime
        );
        $this->db->insert('availability', $data);
    }

    public function removeAvailability($courtId, $reservedDatetime) {
        $this->db->where('court_id', $courtId);
        $this->db->where('available_datetime', $reservedDatetime);
        $this->db->delete('availability');
    }

    public function addBackAvailability($courtId, $availableDatetime) {
        $data = array(
            'court_id' => $courtId,
            'available_datetime' => $availableDatetime
        );
        $this->db->insert('availability', $data);
    }
  

    public function getAvailability($courtId) {
        $this->db->where('court_id', $courtId);
        $query = $this->db->get('availability');
        $result = $query->result_array();

        $availability = array();
        foreach ($result as $row) {
            $availability[] = $row['available_datetime'];
        }

        return $availability;
    }
    public function insertAvailability($court_id, $available_datetime) {
        $data = array(
            'court_id' => $court_id,
            'available_datetime' => $available_datetime
        );

        $this->db->insert('availability', $data);
    }
    public function getAvailableTimes($selectedDate) {
        // Implement your database query to get available times based on the selected date
        // Replace 'availability' and 'available_datetime' with your actual table and column names
        $query = $this->db->select('available_datetime')
                          ->from('availability')
                          ->where('DATETIME(available_datetime)', $selectedDate)
                          ->get();

        return $query->result_array();
    }
    public function getAllCourts() {
        return $this->db->get('court')->result_array();
    }
    public function getAvailableTimeSlots() {
        // Assuming that 'court_reservation' has columns 'start_time', 'end_time', and 'court_id'
        $this->db->select('start_time, end_time, court_id');
        $this->db->where('reservation_date', date('Y-m-d')); // You may need to adjust this condition based on your requirement
        $query = $this->db->get('court_reservation');
    

    $result = $query->result_array();

   
        
        $result = $query->result_array();
    
        // Process the result to format it as an array of time slots for each court
        $available_time_slots = array();
        foreach ($result as $row) {
            $court_id = $row['court_id'];
            $start_time = $row['start_time'];
            $end_time = $row['end_time'];
    
            $available_time_slots[$court_id][] = $start_time . ' - ' . $end_time;
        }
    
        return $available_time_slots;
    }
    public function reserveTimeSlot($data) {
        // Check if the selected time slot is available
        $this->db->where('court_id', $data['court_id']);
        $this->db->where('reservation_date', $data['reservation_date']);
        $this->db->where('start_time', $data['start_time']);
        $query = $this->db->get('court_reservation');
    
        if ($query->num_rows() > 0) {
            // The time slot is already reserved, handle accordingly
            return false;
        } else {
            // Insert the reservation
            $this->db->insert('court_reservation', $data);
            return true;
        }
    }
    public function generateTimeSlots($courtId, $reservationDate) {
        $start_time = new DateTime('08:00:00');
        $end_time = new DateTime('22:00:00');
        $interval = new DateInterval('PT1H'); // 1-hour interval

        $timeslots = array();

        while ($start_time < $end_time) {
            $timeslot = array(
                'court_id' => $courtId,
                'reservation_date' => $reservationDate,
                'start_time' => $start_time->format('H:i:s'),
                'end_time' => $start_time->add($interval)->format('H:i:s'),
                'user_name' => '', // You can set a default value
            );

            $timeslots[] = $timeslot;
        }

        // Insert generated time slots into the database
        $this->db->insert_batch('court_reservation', $timeslots);
    }
    public function generateTimeSlotsForYear($year) {
        $start_date = $year . '-01-01';
        $end_date = $year . '-12-31';
    
        $start_time = new DateTime('08:00:00');
        $end_time = new DateTime('22:00:00');
        $interval = new DateInterval('PT1H'); // 1-hour interval
    
        $time_slots = array();
    
        $current_date = new DateTime($start_date);
    
        while ($current_date <= new DateTime($end_date)) {
            $current_time = clone $start_time;
    
            while ($current_time < $end_time) {
                $time_slots[] = array(
                    'court_id' => 1, // Replace with the actual court ID
                    'reservation_date' => $current_date->format('Y-m-d'),
                    'start_time' => $current_time->format('H:i:s'),
                    'end_time' => $current_time->add($interval)->format('H:i:s'),
                    'user_name' => '', // You can set a default value
                );
            }
    
            $current_date->modify('+1 day');
            $current_time = clone $start_time;
        }
    
        // Insert generated time slots into the database
        $this->db->insert_batch('court_time_slots', $time_slots);
    }
    public function isTimeslotAvailable($courtId, $date, $startTime, $endTime) {
        $this->db->where('court_id', $courtId);
        $this->db->where('availability_date', $date);
        $this->db->where('start_time <', $endTime);
        $this->db->where('end_time >', $startTime);

        $query = $this->db->get('court_availability');

        return $query->num_rows() == 0;
    }
    public function getEvents() {
        $this->db->select('availability_id as id, court_id, availability_date as start, start_time as startTime, end_time as endTime');
        $query = $this->db->get('court_availability');

        return $query->result_array();
    }
    public function nsertAvailability($courtId, $date, $startTime) {
        // Adjust the database table and column names based on your actual structure
        $data = array(
            'court_id' => $courtId,
            'availability_date' => $date,
            'start_time' => $startTime,
            'end_time' => date('H:i:s', strtotime($startTime . ' +1 hour')),
        );

        $this->db->insert('court_availability', $data);
    }
    public function get_available_times($selected_date) {
        // Get all reservations for the specified date
        $this->db->select('StartTime, EndTime');
        $this->db->from('testreserve');
        $this->db->where('Date', $selected_date);
        $query = $this->db->get();
        $reserved_times = $query->result();
    
        // Generate all possible times between 8 am to 10 pm
        $all_times = $this->generate_times('09:00:00', '22:00:00');
    
        // Remove reserved times from the available times
        $available_times = array_diff($all_times, $this->extract_reserved_times($reserved_times));
    
        return $available_times;
    }
    
    
    
    
    
    private function generate_times($start_time, $end_time) {
        $times = array();
        $current_time = strtotime($start_time);

        while ($current_time <= strtotime($end_time)) {
            $times[] = date('h:i A', $current_time);
            $current_time += 60 * 60; // increment by 1 hour
        }

        return $times;
    }

    private function extract_reserved_times($reserved_times) {
        $times = array();

        foreach ($reserved_times as $reserved_time) {
            $start_time = date('h:i A', strtotime($reserved_time->StartTime));
            $end_time = date('h:i A', strtotime($reserved_time->EndTime));

            // Add all times between start and end time to the reserved times array
            $times = array_merge($times, $this->generate_times($start_time, $end_time));
        }

        return $times;
    }
    public function get_court_categories() {
        return array(
            'special_court' => array('start_court' => 1, 'end_court' => 3, 'start_time' => '08:00:00', 'end_time' => '22:00:00', 'fee' => 250),
            'regular_court' => array('start_court' => 4, 'end_court' => 8, 'start_time' => '08:00:00', 'end_time' => '22:00:00', 'fee' => 210),
            'beginner_court' => array('start_court' => 9, 'end_court' => 11, 'start_time' => '08:00:00', 'end_time' => '22:00:00', 'fee' => 180),
        );
    }
    // Inside bud_model.php
public function auto_assign_court($court_category) {
    // Query the database to get an available court within the specified category
    $this->db->select('court_id');
    $this->db->from('court');
    $this->db->where('category', $court_category);
    $this->db->where('is_available', 1); // Assuming you have a column indicating whether a court is available
    $this->db->limit(1);
    $query = $this->db->get();

    if ($query->num_rows() > 0) {
        // Court found, return the court_id
        return $query->row('court_id');
    } else {
        // No available court in the specified category
        return false;
    }
}


    public function get_sports() {
        return array(
            'badminton' => array('id' => 1, 'name' => 'Badminton', 'fee' => 50),
            'pickleball' => array('id' => 2, 'name' => 'Pickleball', 'fee' => 50),
            'table_tennis' => array('id' => 3, 'name' => 'Table Tennis', 'fee' => 50),
            'darts' => array('id' => 4, 'name' => 'Darts', 'fee' => 50),
            // Add more sports as needed
        );
    }
    public function insert_reservation($data) {
        // Insert reservation data into the 'testreserve' table
        $this->db->insert('testreserve', $data);
    
        // Check if the insertion was successful
        return $this->db->affected_rows() > 0;
    }
    public function process_reservation() {
        // Implement logic to process the reservation
        // This could involve inserting data into the database, etc.

        // For demonstration purposes, let's assume the reservation is successful
        // and no database interaction is required in this example.
    }

    public function getReservationsByUserEmail($userEmail)
    {
        $this->db->select('*');
        $this->db->from('reservations');
        $this->db->where('user_email', $userEmail);
        $query = $this->db->get();

        return $query->result();
    }
    // In your Bud_model.php

public function get_available_times_by_date($selectedDate) {
    // Get all reservations for the selected date
    $this->db->select('StartTime, EndTime');
    $this->db->from('testreserve');
    $this->db->where('Date', $selectedDate);
    $query = $this->db->get();
    $reservedTimes = $query->result();

    // Generate all possible times between 8 am to 10 pm
    $allTimes = $this->generate_times2('09:00:00', '22:00:00');

    // Remove reserved times from the available times
    $availableTimes = array_diff($allTimes, $this->extract_reserved_times2($reservedTimes));

    return $availableTimes;
}

private function generate_times2($startTime, $endTime) {
    $times = array();
    $currentTime = strtotime($startTime);

    while ($currentTime <= strtotime($endTime)) {
        $times[] = date('h:i A', $currentTime);
        $currentTime += 60 * 60; // increment by 1 hour
    }

    return $times;
}

private function extract_reserved_times2($reservedTimes) {
    $times = array();

    foreach ($reservedTimes as $reservedTime) {
        $startTime = date('h:i A', strtotime($reservedTime->StartTime));
        $endTime = date('h:i A', strtotime($reservedTime->EndTime));

        // Add all times between start and end time to the reserved times array
        $times = array_merge($times, $this->generate_times($startTime, $endTime));
    }

    return $times;
}

}

        
