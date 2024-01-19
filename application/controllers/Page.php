<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Page extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->model('bud_model');
        $this->load->library('session');
        $this->load->library('email');





    }
    public function landing_page()
    {


        $this->load->view('template/header');
        $this->load->view('page/landing_page');


    }
  

    public function availability_view() {
        // Load the model
        $this->load->model('bud_model');

        // Get all courts
        $data['courts'] = $this->bud_model->getAllCourts();

        // Get availability for each court
        $data['availability'] = array();
        foreach ($data['courts'] as $court) {
            $data['availability'][$court['court_id']] = $this->bud_model->getAvailability($court['court_id']);
        }

        // Load the view
        $this->load->view('page/availability_view', $data);
    }
    
    public function generateAvailabilityDates() {
        // Load the necessary models and libraries
        $this->load->model('bud_model');

        // Set the court_id for which you want to generate availability
        $court_id = 1; // Change this to the desired court_id

        // Set the start and end date for the year
        $start_date = date('Y-m-d'); // Current date
        $end_date = date('Y-m-d', strtotime('+1 year'));

        // Generate availability dates
        $current_date = $start_date;
        while ($current_date <= $end_date) {
            // Check if the date is not in the past
            if (strtotime($current_date) >= strtotime(date('Y-m-d'))) {
                // Insert the availability into the database
                $this->bud_model->insertAvailability($court_id, $current_date);
            }

            // Move to the next day
            $current_date = date('Y-m-d', strtotime($current_date . '+1 day'));
        }

        echo 'Availability dates generated successfully.';
    }
    public function reservation_view() {
        $this->load->helper('form');
        $this->load->model('bud_model');

        // Get available times
        $data['available_times'] = $this->bud_model->get_available_times();

        // Load the view
        $this->load->view('page/reservation_view', $data);
    }
    public function reservationviewprocess() {
        // Load necessary helpers and models
        $this->load->helper('form');
        $this->load->model('bud_model');
    
        // Validate form data
        $this->form_validation->set_rules('start_time', 'Start Time', 'required');
        $this->form_validation->set_rules('end_time', 'End Time', 'required');
    
        if ($this->form_validation->run() == FALSE) {
            // Form validation failed, show the form again with errors
            $this->index();
        } else {
            // Form validation passed, process the reservation
    
            // Get the form data
            $start_time = $this->input->post('start_time');
            $end_time = $this->input->post('end_time');
    
            // Additional validation or business logic can be performed here
    
            // Insert reservation data into the database
            $reservation_data = array(
                'StartTime' => $start_time,
                'EndTime' => $end_time,
                'Username' => 'JohnDoe', // Replace with the actual username or user ID
                'court_id' => 1, // Replace with the actual court ID
                'sport_id' => 1, // Replace with the actual sport ID
            );
    
            // Insert reservation data into the database using the model
            $this->bud_model->insert_reservation($reservation_data);

    
            // Redirect to a success page or show a success message
            $this->load->view('page/landing_page');
        }
    }
    
    
    // Your controller method
public function generateTimeSlotsForAllCourts() {
    // Assuming $reservationDate is obtained from user input or other sources
    $reservationDate = '2023-12-29'; // Replace with the actual reservation date

    $this->load->model('Bud_model');

    // Assuming you have an array of court IDs or you can retrieve it from the database
    $courtIds = array(1, 2, 3, 4);

    foreach ($courtIds as $courtId) {
        $this->bud_model->generateTimeSlots($courtId, $reservationDate);
    }


}

public function fetch_available_time_slots() {
    // Retrieve date parameter from the AJAX request
    $selectedDate = $this->input->get('date');

    // Load the database library
    $this->load->database();

    // Query the database
    $query = $this->db->select('time_slot')
                     ->from('available_time_slots')
                     ->where('date', $selectedDate)
                     ->get();

    $availableTimeSlots = $query->result_array();

    // Return JSON response
    $this->output->set_content_type('application/json');
    $this->output->set_output(json_encode(['availableTimeSlots' => $availableTimeSlots]));
}


  /*   public function reserve() {
        // Form validation
        $this->load->library('form_validation');
        $this->form_validation->set_rules('court', 'Court', 'required|integer');
        $this->form_validation->set_rules('date', 'Date', 'required|date');
        $this->form_validation->set_rules('time_slot', 'Time Slot', 'required');
        $this->form_validation->set_rules('user_name', 'User Name', 'required');
        $this->form_validation->set_rules('hours', 'Hours', 'required|integer');
    
        if ($this->form_validation->run() == FALSE) {
            // Form validation failed, redirect back to the reservation form
            redirect('reservation');
        } else {
            // Form validation passed, process reservation
    
            // Get form data
            $court_id = $this->input->post('court');
            $reservation_date = $this->input->post('date');
            $selected_time_slot = $this->input->post('time_slot');
            $user_name = $this->input->post('user_name');
            $selected_hours = $this->input->post('hours');
    
            // Extract start and end time from the selected time slot
            list($start_time, $end_time) = explode(' - ', $selected_time_slot);
    
            // Calculate end time based on selected hours
            $end_time = date('H:i', strtotime($start_time) + ($selected_hours * 3600));
    
            // Check if the selected time slot is available
            $data = array(
                'court_id' => $court_id,
                'reservation_date' => $reservation_date,
                'start_time' => $start_time,
                'end_time' => $end_time,
                'user_name' => $user_name
            );
    
            if ($this->bud_model->reserveTimeSlot($data)) {
                // Reservation successful
    
                // Optionally, you can add a success message and redirect to a confirmation page
                $this->session->set_flashdata('success_message', 'Reservation successful!');
                redirect('page/reservation_view');
            } else {
                // Time slot is not available, handle accordingly
    
                // Optionally, you can add an error message and redirect back to the reservation form
                $this->session->set_flashdata('error_message', 'Selected time slot is not available. Please choose another.');
                redirect('page/reservation_view');
            }
        }
    }
 */
     public function timeslot() {
        // Example: Generate time slots for the year 2024
$this->bud_model->generateTimeSlotsForYear(2024);

     }
     public function checkAvailability($courtId, $date, $startTime, $endTime) {
        $isAvailable = $this->bud_model->isTimeslotAvailable($courtId, $date, $startTime, $endTime);

        if ($isAvailable) {
            echo 'Timeslot is available.';
        } else {
            echo 'Timeslot is not available.';
        }
    }
    public function fetch_events() {
        // Retrieve events data from the database using your model
        $events = $this->bud_model->getEvents();

        // Return events data in JSON format
        echo json_encode($events);
    }
    public  function populate_availability() {
        // Load the model
        $this->load->model('bud_model');

        // Define the court IDs and the date range (adjust as needed)
        $courtIds = range(1, 11); // Example court IDs
        $startDate = '2024-01-01'; // Example start date
        $endDate = '2024-12-31';   // Example end date

        // Generate time slots from 8 am to 11 pm with a 1-hour interval
        $startTime = new DateTime('08:00:00');
        $endTime = new DateTime('23:00:00');
        $interval = new DateInterval('PT1H');
        $timeSlots = array();

        while ($startTime <= $endTime) {
            $timeSlots[] = $startTime->format('H:i:s');
            $startTime->add($interval);
        }

        // Calculate the number of rows per court
        $rowsPerCourt = ceil(1000 / count($courtIds) / count($timeSlots) / (new DateTime($endDate))->diff(new DateTime($startDate))->days);

        // Insert data into the table
        foreach ($courtIds as $courtId) {
            $currentDate = new DateTime($startDate);

            while ($currentDate <= new DateTime($endDate)) {
                for ($i = 0; $i < $rowsPerCourt; $i++) {
                    foreach ($timeSlots as $timeSlot) {
                        $this->bud_model->nsertAvailability($courtId, $currentDate->format('Y-m-d'), $timeSlot);
                    }
                }

                $currentDate->add(new DateInterval('P1D'));
            }
        }

        echo "Data populated successfully.";
    }    
    public function court_layout()
    {


        $this->load->view('template/header');
        $this->load->view('page/courtlayout');


    }
    public function availabilityreservation()
    {


        $this->load->view('template/header');
        $this->load->view('page/availabilityreservation');


    }
    public function get_available_times() {
        // Check if the selected_date parameter is set in the POST request
        if ($this->input->post('selected_date')) {
            $selectedDate = $this->input->post('selected_date');

            // Load your model (replace 'Availability_model' with your actual model name)
            $this->load->model('bud_model');

            // Call the model method to get available times
            $data['availableTimes'] = $this->bud_model->getAvailableTimes($selectedDate);

            // Load the view to display available times
            $this->load->view('[page/availability_times_view', $data);
        } else {
            // Handle the case where selected_date is not provided
            echo '<p>Invalid request. Please provide a selected_date parameter.</p>';
        }
    }
    public function check_availability() {
        $data['sports'] = ['Badminton', 'Table Tennis', 'Pickleball', 'Darts'];

        if ($this->input->post()) {
            $selected_sport = $this->input->post('sport');
            $selected_hours = $this->input->post('hours');
            $selected_date = $this->input->post('date');
            // Add your logic to check availability and retrieve data

            // For demonstration purposes, let's assume $available_courts is an array of available courts
            $data['available_courts'] = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11];
        }

        $this->load->view('reservation_schedule_modal', $data);
    }
    public function history()
    {

        $this->load->model('bud_model');
        $this->load->view('template/adminheader');
        $data['declined'] = $this->bud_model->get_all_declined();
        $this->load->view('page/history', $data);


    }
    public function reserve()
    {
        // Check if the user is logged in
        if (!$this->session->userdata('id')) {
            // If not logged in, redirect to the login page
            redirect('page/loginview');
        }
        $data['available_times'] = $this->bud_model->get_available_times();



        $this->load->view('template/header');
        $this->load->view('page/reserve',$data);


    }
    public function test2()
    {
        // Check if the user is logged in
        if (!$this->session->userdata('id')) {
            // If not logged in, redirect to the login page
            redirect('page/loginview');
        }
        $data['available_times'] = $this->bud_model->get_available_times();



        $this->load->view('template/header');
        $this->load->view('page/test2',$data);


    }


    public function register()
    {
        $data['user_signed_in'] = $this->session->userdata('user_signed_in');

        // Load the login view and pass the $data array to it
        $this->load->view('template/header', $data);
        $this->load->view('page/register');

    }

    public function login()
    {
        $this->load->view('template/header');
        $this->load->view('page/loginview');
    }
    



    public function test()
    {
        // Check if the user is logged in
        if (!$this->session->userdata('id')) {
            // If not logged in, redirect to the login page
            redirect('page/loginview');
        }

        // Get the user's role from the session
        $user_role = $this->session->userdata('role');

        // Check if the user's role is 'admin'
        if ($user_role !== 'admin') {
            // If the user is not an admin, redirect them to a different page
            redirect('page/landing_page'); // Redirect to a landing page for regular users
        }
        // This part of the code is not executed if the user is redirected
        $this->load->model('bud_model');
        $this->load->view('template/adminheader');
        $data['reservations'] = $this->bud_model->get_all_reservations();
        $data['ongoing_reservations'] = $this->bud_model->getOngoingReservations();
        $data['future_reservations'] = $this->bud_model->getFutureReservations();
        $this->load->view('page/test', $data);
    }


    public function reserved()
    {
        // Check if the user is logged in
        if (!$this->session->userdata('id')) {
            // If not logged in, redirect to the login page
            redirect('page/loginview');
        }

        // Get the user's role from the session
        $user_role = $this->session->userdata('role');

        // Check if the user's role is 'admin'
        if ($user_role !== 'admin') {
            // If the user is not an admin, redirect them to a different page
            redirect('page/landing_page'); // Redirect to a landing page for regular users
        }
        $this->load->model('bud_model');
        $this->load->view('template/adminheader');
        $data['future_reservations'] = $this->bud_model->getFutureReservations();

        $this->load->view('page/reserved', $data);

    }


    public function register_form()
    {
        $this->form_validation->set_error_delimiters('<div class="error alert alert-dark">', '</div');

        $this->form_validation->set_rules('name', 'Full Name', 'trim|required');
        $this->form_validation->set_rules('email', 'E-Mail Address', 'trim|required|valid_email|is_unique[users.email]');
        $this->form_validation->set_message('is_unique', 'The Email is already taken. Please choose a different Email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[10]');
        $this->form_validation->set_rules('con_password', 'Confirm Password', 'trim|required|matches[password]');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('page/register');
        } else {
            $data = array(
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password'),
                'role' => 'user',
                'email_verified' => 0,
                'email_verification_token' => md5(uniqid(rand(), true))
            );

            if ($this->bud_model->check_email_exist($data['email'])) {
                $this->session->set_flashdata('error', 'Email already exists.');
                redirect('page/register');
            }

            if ($this->bud_model->register_user($data)) {
                // Pass the email and verification token to the sendVerificationEmail function
                $this->sendVerificationEmail($data['email'], $data['email_verification_token']);

                $successMessage = 'Registered successfully. Check your email for verification.';
                echo "<script>showSuccessToast('$successMessage');</script>";

                redirect('page/loginview');
            } else {
                $this->session->set_flashdata('error', 'Registration failed.');
                redirect('page/register');
            }
        }
    }

    public function sendVerificationEmail($email, $verificationToken)
    {
        $this->load->library('ciqrcode');
        $this->load->model('bud_model'); // Load the QRCode_model
    
        // Check if the user with the given verification token exists in the database
        $userDetails = $this->bud_model->get_user_by_verification($verificationToken);
    
        if ($userDetails) {
            $dataToPass = array(
                'email' => $userDetails->email,
                'password' => $userDetails->password
            );
    
            // Encode the data to pass as a JSON string
            $dataParam = json_encode($dataToPass);
    
            // Generate the QR code image
            $params['data'] = base_url('page/qrlogin') . '?data=' . urlencode($dataParam);
            $params['level'] = 'H';
            $params['size'] = 10;
            $params['savename'] = FCPATH . "application/uploads/qr_code_{$verificationToken}.jpg";
            $this->ciqrcode->generate($params);
    
            $subject = 'Email Verification';
            $verificationLink = base_url('Page/verify_email?token=' . $verificationToken);
            $message = 'Click the following link to verify your email address: <a href="' . $verificationLink . '">' . $verificationLink . '</a>'.'You can use the qrcode below to login to your account';
            $from_name = "Budz Badminton Court";
            $from = "patrickjeri.garcia@sdca.edu.ph";
            $add_data = array();
            $this->email->attach(FCPATH . "application/uploads/qr_code_{$verificationToken}.jpg");
    
            // Now, you can use the provided email and modified message to send the verification email
            $this->mailer_withhtml($from, $from_name, $email, $subject, $message, $add_data);

            
            
        }
        
    }
    

    public function verify_email()
    {
        $token = $this->input->get('token'); // Get the verification token from the URL

        // Check if the token is valid
        $user = $this->bud_model->get_user_by_verification_token($token);

        if ($user) {
            // Update the user's email_verified status to 1
            $this->bud_model->update_email_verification_status($user['id'], 1);

            // You can also set a flash message or redirect the user to a success page
            $this->session->set_flashdata('success', 'Email verification successful. You can now log in.');
            redirect('page/loginview');
        } else {
            // Token is invalid or user not found
            $this->session->set_flashdata('error', 'Invalid verification token.');
            redirect('page/loginview');
        }
    }
    public function qrlogin()
    {
        // Retrieve the 'data' parameter from the URL
        $encoded_data = $this->input->get('data');
    
        // Decode the JSON data
        $decoded_data = json_decode(urldecode($encoded_data), true);
 
        // Pass the decoded data to the view
        $data['userDetails'] = $decoded_data;
    
        $this->load->view('template/header');
        $this->load->view('page/qrlogin', $data);
    }
    
    


    public function main()
    {
        if (!$this->session->userdata('id')) {
            // If not logged in, redirect to the login page
            redirect('page/loginview');
        }

        // Load necessary models and libraries
        $this->load->model('bud_model');
       

        // Check if the cancellation form is submitted
        if ($this->input->post('cancel_reservation')) {
            $reservationId = $this->input->post('reservation_id');

            // Attempt to cancel the reservation
            $cancellationResult = $this->bud_model->cancelReservation($reservationId);

            // Log the cancellation result
            $this->logCancellation($cancellationResult);

            // Set flash messages based on the cancellation result
            if ($cancellationResult) {
                $this->session->set_flashdata('success', 'Reservation canceled successfully.');
            } else {
                $this->session->set_flashdata('error', 'Reservation cancellation not allowed.');
            }

            // Redirect back to the user profile page
            redirect('Page/main');
        }

        // Load user profile view
        $this->load->view('template/header');
        $data['name'] = $this->session->userdata('name');
        $data['reservations'] = $this->bud_model->getUserReservations($this->session->userdata('id'));
        $this->load->view('page/index', $data);
        $this->load->view('template/footer');
    }

    private function logCancellation($result)
    {
        // Your logging logic goes here
        if ($result) {
            log_message('info', 'Reservation canceled successfully.');
        } else {
            log_message('error', 'Failed to cancel reservation or cancellation not allowed.');
        }
    }

    public function admin()
    {
        // Check if the user is logged in
        if (!$this->session->userdata('id')) {
            // If not logged in, redirect to the login page
            redirect('page/loginview');
        }

        // Get the user's role from the session
        $user_role = $this->session->userdata('role');

        // Check if the user's role is 'admin'
        if ($user_role !== 'admin') {
            // If the user is not an admin, redirect them to a different page
            redirect('page/landing_page'); // Redirect to a landing page for regular users
        }

        // If the user is an admin, load the admin page
        $this->load->view('template/adminheader');
        /*  $data['reservations'] = $this->bud_model->get_all_reservations();
         $this->load->view('page/admin', $data); */
        $data['sport_frequency'] = $this->bud_model->getSportFrequency();
        $data['futureReservations'] = $this->bud_model->getrepReservations();
        $data['canceledCount'] = $this->bud_model->getCanceledCount();
        $data['declinedCount'] = $this->bud_model->getDeclinedCount();
        $data['pendingCount'] = $this->bud_model->getpendingCount();

      
        $this->load->view('page/admin', $data);
    }


    public function gallery()
    {
        $this->load->model('bud_model');
        $this->load->view('template/header');
        $this->load->view('page/gallery');

    }
    public function court_status()
    {
        $this->load->model('bud_model');
        $this->load->view('template/adminheader');
        $data['courts'] = $this->bud_model->get_all_courts();
        $this->load->view('page/court_status', $data);
    }


    public function canceled()
    {
        $this->load->model('bud_model');
        $data['canceled'] = $this->bud_model->get_all_canceled_reservations();
        $this->load->view('template/adminheader');
        $this->load->view('page/canceled', $data);
    }


    public function submit_reserve()
    {
        $this->load->model('bud_model');

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $name = $this->session->userdata('name');
            $email = $this->session->userdata('email');
            $userDateTime = $this->input->post('datetime');
            $userTime = $this->input->post('timePicker');
            $court = $this->input->post('court');
            $sport = $this->input->post('sport');
            $hours = $this->input->post('hours');
            $qr_code_model = new bud_model();
            $qr_code = $qr_code_model->generateRandomQRCode(27);
            // Get the uploaded image file
            $image = $_FILES['referenceNum'];

            // Set the upload path and file name
            $uploadPath = './payment/';
            $fileName = basename($image['name']);
            $filePath = $uploadPath . $fileName;

            // Move the uploaded file to the upload path
            if (move_uploaded_file($image['tmp_name'], $filePath)) {
                echo "File uploaded successfully";
            } else {
                echo "Error uploading file";
            }

            $userTimezone = new DateTimeZone('Asia/Manila');
            $userDateTime = $userDateTime . ' ' . $userTime; // Combine date and time
            $dateTime = new DateTime($userDateTime, $userTimezone); // Create a DateTime object
            $utcDatetime = $dateTime->format('Y-m-d H:i:s');

            $data = array(
                'reserved_datetime' => $utcDatetime,
                'court' => $court,
                'sport' => $sport,
                'user_name' => $name,
                'user_email' => $email,
                'hours' => $hours,
                'image' => $filePath,
                'qr_code' => $qr_code,

            );

            if ($this->db->insert('reservations', $data)) {
                echo "Reservation created successfully";
            } else {
                echo "Error creating reservation";
            }
        }
    }


    public function pay()
    {
        $this->load->view("page/payment");
    }
    public function scan()
    {
        $this->load->view("page/scan");
    }


    public function approved()
    {
        // Check if the user is logged in
        if (!$this->session->userdata('id')) {
            // If not logged in, redirect to the login page
            redirect('page/loginview');
        }

        // Get the user's role from the session
        $user_role = $this->session->userdata('role');

        // Check if the user's role is 'admin'
        if ($user_role !== 'admin') {
            // If the user is not an admin, redirect them to a different page
            redirect('page/landing_page'); // Redirect to a landing page for regular users
        }



        $this->load->model('bud_model');
        $this->load->view('template/adminheader');
        $data['ongoing'] = $this->bud_model->get_all_reservations_ongoing();
        $this->load->view('page/approved', $data);

    }


    public function get_reservations()
    {
        $this->load->model('bud_model');

        $reservations = $this->bud_model->getReservations();

        $events = [];
        foreach ($reservations as $reservation) {
            $randomColor = $this->generateRandomColor();

            $events[] = [
                'title' => $reservation->court . ' ' . $reservation->sport,
                'start' => $reservation->reserved_datetime,
                'color' => $randomColor,
                'description' => 'Date: ' . date('Y-m-d', strtotime($reservation->reserved_datetime)) . '<br>' .
                    'Time: ' . date('H:i', strtotime($reservation->reserved_datetime)) . '<br>' .
                    'Court: ' . $reservation->court . '<br>' . // Include court information
                    'Sport: ' . $reservation->sport,
                // Include sport information
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($events);
    }
    public function get_reservations_for_date_time()
    {
        $date = $this->input->post('date');
        $time = $this->input->post('time');

        $this->load->model('bud_model');
        $reservations = $this->bud_model->getReservationsForDateTime($date, $time);

        header('Content-Type: application/json');
        echo json_encode($reservations);
    }



    // Function to generate a random color
    private function generateRandomColor()
    {
        $letters = '0123456789ABCDEF';
        $color = '#';
        for ($i = 0; $i < 6; $i++) {
            $color .= $letters[rand(0, 15)];
        }
        return $color;
    }

    public function get_approved_reservations()
    {
        // Load the Reservations_model
        $this->load->model('bud_model');

        // Fetch approved reservations from the model
        $approved_reservations = $this->bud_model->get_a_reservations();

        // Return the JSON response
        $this->output->set_content_type('application/json')->set_output(json_encode($approved_reservations));
    }
    public function get_reservations_for_date()
    {
        $date = $this->input->post('date');
        $this->load->model('bud_model');
        $reservations = $this->bud_model->getReservationsForDate($date);
        header('Content-Type: application/json');
        echo json_encode($reservations);
    }

    public function make_reservation()
    {
        $selectedDate = $this->input->post('date');
        $selectedTime = $this->input->post('time');
        $selectedCourtId = $this->input->post('court');
        $selectedSportId = $this->input->post('sport');

        // Fetch reservations for the selected date and time
        $reservations = $this->bud_model->getReservationsWithinTimeFrame($selectedCourtId, $selectedSportId, $selectedDate, $selectedTime, $selectedTime);

        // Check if there are any existing reservations within the allowed time frame
        if (!empty($reservations)) {
            echo 'existing_reservation';
            return;
        }

        // Check if the selected court and sport combination is available
        $availability = $this->bud_model->checkCourtSportAvailability($selectedCourtId, $selectedSportId, $selectedDate, $selectedTime);

        if ($availability) {
            // Proceed with the reservation
            $reservationData = [
                'reserved_datetime' => $selectedDate . ' ' . $selectedTime,
                'court' => $selectedCourtId,
                'sport' => $selectedSportId,
                // Add other reservation data as needed
            ];

            // Insert the reservation data into the database
            $inserted = $this->bud_model->insertReservation($reservationData);

            if ($inserted) {
                echo 'success';
            } else {
                echo 'error';
            }
        } else {
            echo 'not_available';
        }
    }



    public function approve_reservation($reservationId)
    {
        $this->load->model('bud_model');
        $reservation = $this->bud_model->getReservation($reservationId);

        if ($reservation->status === 'pending') {
            // Check if the reservation date is today
            $today = date('Y-m-d');
            $reservationDate = date('Y-m-d', strtotime($reservation->reserved_datetime));

            if ($reservationDate === $today) {
                $this->bud_model->updateStatus($reservationId, 'approved');
                $this->bud_model->transferToToday($reservation);
            } else {
                // If it's in the future, update status to 'approved' and transfer to the "future" table
                $this->bud_model->updateStatus($reservationId, 'approved');
                $this->bud_model->transferToFuture($reservation);
                $this->bud_model->transferToToday($reservation);
            }

            // Remove the reservation from the "reservations" table
            $this->bud_model->removeReservation($reservationId);



            $response = array('status' => 'success');
        } else {
            $response = array('status' => 'error', 'message' => 'Reservation not pending');
        }

        // Send the response as JSON
        $this->output->set_content_type('application/json')->set_output(json_encode($response));

    }




    public function sendReservationApprovalEmail($userEmail)
    {
        $subject = 'Reservation Approved';
        $message = 'Your reservation has been approved.';
        $from_name = "Budz Badminton Court";
        $from = "patrickjeri.garcia@sdca.edu.ph";

        $add_data = array();

        $this->mailer_withhtml($from, $from_name, $userEmail, $subject, $message, $add_data);
    }

    public function getReservation($reservationId)
    {
        $this->db->where('id', $reservationId);
        $reservation = $this->db->get('reservations')->row();

        if ($reservation) {
            // Create a string with reservation details
            $reservationDetails = 'Date: ' . date('Y-m-d', strtotime($reservation->reserved_datetime)) . "\n";
            $reservationDetails .= 'Time: ' . date('H:i', strtotime($reservation->reserved_datetime)) . "\n";
            $reservationDetails .= 'Court: ' . $reservation->court . "\n";
            $reservationDetails .= 'Sport: ' . $reservation->sport;

            // Set the directory path for the QR codes
            $qrCodeDirectory = FCPATH . 'application\qrcodes';
            $qrCodeCacheDirectory = FCPATH . 'application\qrcache';

            // Check if the QR code directory exists, if not, create it
            if (!is_dir($qrCodeDirectory)) {
                mkdir($qrCodeDirectory, 0777, true);
            }

            // Check if the cache directory exists, if not, create it
            if (!is_dir($qrCodeCacheDirectory)) {
                mkdir($qrCodeCacheDirectory, 0777, true);
            }

            // Generate a QR code with the reservation details
            $this->load->library('ciqrcode');
            $config['cacheable'] = true; // Cache the image to improve performance
            $config['cachedir'] = $qrCodeCacheDirectory; // Set the cache directory
            $config['quality'] = true; // High-quality QR code
            $config['size'] = '1024'; // QR code size
            $config['black'] = array(255, 255, 255); // QR code color
            $config['white'] = array(0, 0, 0); // Background color

            $config['level'] = 'H'; // Error correction level
            $config['savename'] = $qrCodeDirectory . $reservationId . '.jpg'; // Set the filename with the reservation ID
            $config['data'] = $reservationDetails; // Reservation details as data

            $this->ciqrcode->initialize($config);
            $this->ciqrcode->generate();

            // Set the QR code image filename in the reservation object
            $reservation->qr_code_filename = $reservationId . '.jpg';
        }

        return $reservation;
    }
    public function courtvisual()
    {
        // Load the view
        $this->load->view('page/courtvisual');
    }




    public function decline_reservation($reservationId)
    {
        $this->load->model('bud_model');
        $reservation = $this->bud_model->getReservation($reservationId);

        if ($reservation->status === 'pending') {
            // Update the status to 'approved' in the "reservations" table
            $this->bud_model->updateStatus($reservationId, 'declined');

            // Transfer approved reservation to the "today" table
            $this->bud_model->transferTodeclined($reservation);

            // Update status in the "today" table
            $this->bud_model->updateDeclinedStatus($reservation->reserved_datetime, 'declined');

            // Remove the reservation from the "reservations" table
            $this->bud_model->removeReservation($reservationId);

            $response = array('status' => 'success');
        } else {
            $response = array('status' => 'error', 'message' => 'Reservation not pending.');
        }

        // Send the response as JSON
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    public function get_court_choices()
    {
        $this->load->database();


        $query = $this->db->get('courts');


        if ($query->num_rows() > 0) {

            $courts = $query->result_array();


            echo json_encode($courts);
        } else {

            echo json_encode([]);
        }
    }
    public function get_court_special_courts()
    {
        $this->load->database();


        $query = $this->db->get('special courts');


        if ($query->num_rows() > 0) {

            $courts = $query->result_array();


            echo json_encode($courts);
        } else {

            echo json_encode([]);
        }
    }

    public function get_sport_choices()
    {
        $this->load->database();


        $query = $this->db->get('sports');


        if ($query->num_rows() > 0) {

            $sports = $query->result_array();


            echo json_encode($sports);
        } else {

            echo json_encode([]);
        }
    }
    public function grab_reservations()
    {
        // Handle form submission
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');

            // Query to fetch future reservations
            $this->db->where('reserved_datetime >=', $start_date);
            $this->db->where('reserved_datetime <=', $end_date);
            $query = $this->db->get('reservations');

            // Check if there are future reservations
            if ($query->num_rows() > 0) {
                $future_reservations = $query->result_array();

                // Loop through future reservations and insert into the future table
                foreach ($future_reservations as $reservation) {
                    $this->db->insert('future', $reservation);
                }

                // delete from pending
                $this->db->where('reserved_datetime >=', $start_date);
                $this->db->where('reserved_datetime <=', $end_date);
                $this->db->delete('reservations');
            }
        }

        // Load the view with the updated reservation data
        $this->load->view('reservation_view');
    }
    public function move_reservation_to_table($reservationId, $tableName)
    {
        // Check if the $tableName is 'today' or 'future'
        if ($tableName !== 'today' && $tableName !== 'future') {
            echo json_encode(array('status' => 'error', 'message' => 'Invalid table name'));
            return;
        }

        // Check if the reservation with the given ID exists
        $reservation = $this->bud_model->get_reservation_by_id($reservationId);

        if (!$reservation) {
            echo json_encode(array('status' => 'error', 'message' => 'Reservation not found'));
            return;
        }

        // Update the status and move the reservation to the specified table
        $this->load->model('bud_model');
        $data = array('status' => 'approved'); // Update the status as 'approved'
        $this->db->where('id', $reservationId);
        $this->db->update('reservations', $data);



        echo json_encode(array('status' => 'success'));
    }

    public function cancel_reservation()
    {
        $reservationId = $this->input->post('reservationId');
        $this->load->model('bud_model');

        $cancellation_status = $this->bud_model->cancel_and_move_reservation($reservationId);

        if ($cancellation_status === true) {
            echo json_encode(array('status' => 'success'));
        } else {
            echo json_encode(array('status' => 'error'));
        }
    }

    public function reschedule_reservation()
    {
        $this->load->model('bud_model');

        // Retrieve form data

        $reservationId = $this->input->post('reservationId');
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $newReservedDatetime = $this->input->post('newReservedDatetime');
        $newCourt = $this->input->post('court');
        $newSport = $this->input->post('sport');

        // Call the model to update the reservation
        $result = $this->bud_model->updateReservation($reservationId, $name, $email, $newReservedDatetime, $newCourt, $newSport);

        if ($result) {
            $response = array('status' => 'success');
        } else {
            $response = array('status' => 'error');
        }

        echo json_encode($response);
    }
    public function finalize_reservation()
    {
        $this->load->model('bud_model');

        // Retrieve form data

        $reservationId = $this->input->post('reservationId');
        $newReservedDatetime = $this->input->post('newReservedDatetime');
        $newCourt = $this->input->post('court');
        $newSport = $this->input->post('sport');

        // Call the model to update the reservation
        $result = $this->bud_model->updateReservation_for_reservation($reservationId, $newReservedDatetime, $newCourt, $newSport);

        if ($result) {
            $response = array('status' => 'success');
        } else {
            $response = array('status' => 'error');
        }

        echo json_encode($response);
    }
    public function check_court_sport_availability()
    {
        // Get the selected court, sport, date, and time from the AJAX request
        $court = $this->input->post('court');
        $sport = $this->input->post('sport');
        $date = $this->input->post('date');
        $time = $this->input->post('time');

        // Calculate the current time
        $current_time = strtotime('now');

        // Convert the selected time to a timestamp
        $selected_time = strtotime($date . ' ' . $time);

        // Calculate the time difference in seconds
        $time_difference = $selected_time - $current_time;

        // Check if the time difference is at least 1 hour (3600 seconds) or more
        if ($time_difference >= 3600) {
            // Call the model method to check availability
            $availability = $this->bud_model->checkCourtSportAvailability($court, $sport, $date, $time);

            // Return the availability status as a response to the AJAX request
            if ($availability) {
                echo 'available';
            } else {

                echo 'not_available';
            }
        } else {
            // The selected time is less than 1 hour from the current time, so it's not allowed
            echo 'not_allowed';
        }
    }



    public function moveReservations()
    {
        // Get the current date
        $currentDate = date('Y-m-d');

        // Call the model method to move reservations
        $reservationsMoved = $this->bud_model->moveReservationsToOngoing($currentDate);

        if ($reservationsMoved) {
            // Log successful execution or perform other actions
            log_message('info', 'Reservations moved successfully.');
        } else {
            // Log the error or perform error handling
            log_message('error', 'Failed to move reservations.');
        }
    }
    public function getReservations()
    {
        $this->load->model('bud_model');
        $reservations = $this->bud_model->getAllReservations();

        // Prepare the data to be returned as JSON
        $data = array(
            'data' => $reservations
        );

        // Send the data as JSON
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
    public function get_updated_data()
    {
        // Load the updated data from the model
        $updatedData = $this->bud_model->get_reservations();
        echo json_encode($updatedData);
    }
    public function calculate_hours_and_price()
    {
        // Get data from the form
        $selectedDate = $this->input->post('datetime');
        $selectedTime = $this->input->post('time');
        $hours = $this->input->post('hours');

        // Perform your calculations here (e.g., calculate price based on hours)
        // For example, you can assume a fixed price per hour and calculate the total price
        $pricePerHour = 10; // Replace with your actual price per hour
        $totalPrice = $hours * $pricePerHour;

        // Return the result as a JSON response
        $response = [
            'hours' => $hours,
            'totalPrice' => $totalPrice
        ];

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function add()
    {
        // Retrieve form data and perform validation as needed

        // Insert the new court into the database
        $data = array(
            'court_number' => $this->input->post('court_number'),
            'status' => 'available' // Set the initial status as needed
        );
        $this->bud_model->add_court($data);

        // Redirect back to the page displaying the courts
        redirect('page/court_status');
    }






    public function testemail()
    {
        $this->load->view('page/nohtml');
    }
    public function index()
    {
        // Check if the user is already logged in
        if ($this->session->userdata('user_id')) {
            // User is already logged in, redirect to their dashboard
            redirect('dashboard');
        } else {
            // User is not logged in, load the login view
            $this->load->view('login');
        }
    }
    public function process_login()
    {
        // Validate login credentials here
        $this->form_validation->set_rules('email', 'E-Mail Address', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run()) {
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $validate = $this->bud_model->index($email, $password);


            if ($validate) {
                // Check if the user is an admin or a regular user
                if ($validate->role === 'admin') {
                    // Admin, redirect to admin dashboard
                    $user_data = array(
                        'id' => $validate->id,
                        'name' => $validate->name,
                        'email' => $email,
                        'role' => 'admin'
                    );
                    $this->session->set_userdata($user_data);
                    redirect('page/admin');
                } else {
                    // Regular user, redirect to user dashboard or main page
                    $user_data = array(
                        'id' => $validate->id,
                        'name' => $validate->name,
                        'email' => $email,
                        'role' => 'user'
                    );
                    $this->session->set_userdata($user_data);
                    redirect('page/main');
                }
            } else {
                $this->session->set_flashdata('error', 'Invalid login details. Please try again.');
                redirect('page/loginview');
            }
        } else {
            $this->load->view('page/loginview'); // Display the login view
        }
    }

    public function sportFrequency()
    {
        $data['sport_frequency'] = $this->bud_model->getSportFrequency();

        // Load a view to display the report
        $this->load->view('page/sport_frequency', $data);
    }



    public function logout()
    {
        $this->session->unset_userdata('user_id');
        $this->session->sess_destroy();
        redirect('page/loginview');
    }
    public function courts_data()
    {
        $data['court_status'] = $this->bud_model->get_all_courtss();
        $this->load->view('court_status', $data);
    }

    public function update_status($court_id)
    {
        // Get the new status from the form
        $new_status = $this->input->post('status');

        // Load the model
        $this->load->model('bud_model'); // Assuming you have a model named CourtModel

        // Call a method in the model to update the status
        $result = $this->bud_model->update_court_status($court_id, $new_status);

        // Check the result and show a response (e.g., success or failure message)
        if ($result) {
            $response = "Status updated successfully!";
        } else {
            $response = "Failed to update status.";
        }

        // You can send the response back to the view using JSON or any other method you prefer
        echo json_encode(array('message' => $response));
    }

    public function get_status_options()
    {
        $status_options = $this->bud_model->get_distinct_status_options();
        echo json_encode($status_options);
    }
    public function get_court_status()
    {
        // Load the database library if it's not already loaded.
        $this->load->database();

        // Assuming you have a model named 'Court_model' to handle database operations.
        $this->load->model('bud_model');

        // Fetch court choices from your model.
        $court_choices = $this->bud_model->get_court_choices();

        // Return the court choices as a JSON response.
        echo json_encode($court_choices);
    }



    public function blocktime()
    {
        $this->load->model('bud_model'); // Load the model

        // Fetch the blocked times data
        $blockedTimesData = $this->bud_model->getBlockedTimes(); // You need to create this method in your model

        // Pass the data to your view
        $data['blockedTimes'] = $blockedTimesData;

        $this->load->view('template/adminheader');
        $this->load->view('page/blocktime', $data); // Pass the data to your view
    }
    public function testrsrv()
    {
        // Check if the user is logged in
        if (!$this->session->userdata('id')) {
            // If not logged in, redirect to the login page
            redirect('page/loginview');
        }




        $this->load->view('template/header');
        $this->load->view('page/testrsrv');


    }
    public function qrcodetest()
    {


        $this->load->view('template/header');
        $this->load->view('page/qrcodetest');


    }

    public function generate_qrcode($reservationQRCode)
    {
        $this->load->library('ciqrcode');
        $this->load->model('bud_model'); // Load the QRCode_model

        // Check if the reservation with the given QR code exists in the database
        $reservationDetails = $this->bud_model->getReservationDetailsByQRCode($reservationQRCode);

        if ($reservationDetails) {
            $dataToPass = array(
                'qr_code' => $reservationDetails->qr_code,
                'id' => $reservationDetails->id,
                'reserved_datetime' => $reservationDetails->reserved_datetime,
                'status' => $reservationDetails->status,
                'user_name' => $reservationDetails->user_name,
                'user_email' => $reservationDetails->user_email,
                'court' => $reservationDetails->court,
                'sport' => $reservationDetails->sport,
                'hours' => $reservationDetails->hours
            );

            // Encode the data to pass as a JSON string
            $dataParam = json_encode($dataToPass);

            // Generate the QR code image
            $params['data'] = base_url('page/reservation_details_view') . '?data=' . urlencode($dataParam);
            $params['level'] = 'H';
            $params['size'] = 10;
            $params['savename'] = FCPATH . "application/uploads/qr_code_{$reservationQRCode}.jpg";
            $this->ciqrcode->generate($params);

            // Return the data as JSON response
            $response = array(
                'success' => true,
                'message' => 'Reservation details retrieved successfully',
                'data' => $dataToPass
            );

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
        } else {
            // Return a JSON response for not found
            $response = array(
                'success' => false,
                'message' => 'Reservation not found'
            );

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
        }
    }


    /*  public function qr_code_reader() {
         $dataParam = $this->input->get('data');
         $data = json_decode(urldecode($dataParam), true);
         
         $this->load->view('page/qr_code_reader', ['data' => $data]); // Pass the data array as an associative array
     } */
    public function reservation_details_view()
    {
        // Retrieve the 'data' parameter from the URL
        $encoded_data = $this->input->get('data');

        // Decode the JSON data
        $decoded_data = json_decode(urldecode($encoded_data), true);

        // Pass the decoded data to the view
        $data['reservationDetails'] = $decoded_data;

        // Load the HTML view
        $this->load->view('page/reservation_details_view', $data);
    }




    public function displayprice()
    {
        // Get a reference to the hours input field
        $hoursInput = $this->input->post("hours");

        // Get a reference to the reservation details section
        $reservationDetails = "<p id='displayHours'>" . $hoursInput . "</p><p id='displayTotalPrice'>$" . ($hoursInput * 10) . "</p>";

        // Write the new reservation details to the database
        $this->db->set("reservationDetails", $reservationDetails);
        $this->db->update("reservations");
    }
    public function get_category_and_price()
    {
        $court_number = $this->input->post("court_number");

        $this->load->database();

        $query = $this->db->select("category, price")
            ->from("courts")
            ->where("court_id", $court_number)
            ->get();

        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            $category = $row["category"];
            $price = $row["price"];
            echo json_encode(array("category" => $category, "price" => $price));
        } else {
            echo json_encode(array("category" => "N/A", "price" => "N/A"));
        }
    }
    public function testqr()
    {
        $this->load->view("page/testqr");
    }
    public function user_data($userId)
    {
        // Load the User model to fetch data from the database
        $this->load->model('bud_model');

        // Fetch user data from the database using the user ID
        $user_data = $this->bud_model->getUserData($userId);

        if ($user_data) {
            // Load the user_data view and pass the user data to it
            $this->load->view('user_data', $user_data);
        } else {
            // Handle the case where the user data is not found in the database
            echo 'User data not found';
        }
    }
    public function calculate_fee($reservation_id)
    {
        $this->load->database();

        $this->db->select('courts.price * ongoing.hours AS total_fee');
        $this->db->from('courts');
        $this->db->join('ongoing', 'courts.court_number = ongoing.court');
        $this->db->where('ongoing.id', $reservation_id);

        $query = $this->db->get();
        $result = $query->row();

        $total_fee = $result ? $result->total_fee : 0;

        // Load view with total fee
        $data['total_fee'] = $total_fee;
        $this->load->view('receipt_view', $data);
    }


    public function generateReservationQRCode($reservationId)
    {
        $this->load->model('bud_model'); // Replace with your actual model name
        $this->load->library('ciqrcode');

        // Fetch reservation data based on the reservation ID
        $reservation = $this->bud_model->getReservation($reservationId);

        if ($reservation) {
            // Encode the reservation data as a JSON string
            $reservationData = json_encode($reservation);

            // Configuration for generating the QR code
            $config['data'] = $reservationData;
            $config['level'] = 'H'; // Error correction level
            $config['size'] = 10; // Size of the QR code

            // Path to save the QR code image (adjust this path as needed)
            $config['savename'] = FCPATH . 'qrcode' . $reservationId . '.jpg';

            // Generate the QR code
            $this->ciqrcode->initialize($config);
            $this->ciqrcode->generate();
        }

        // Load a view to display the QR code and reservation details
        $data = [
            'reservations' => $reservation,
            'qrCodeImage' => base_url('qrcodes' . $reservationId . '.jpg'),
        ];
        $this->load->view('page/qr_code_reader', $data);
    }

    public function timeslots()
    {

        $data['timeslots'] = $this->bud_model->get_timeslots();
        $this->load->view('page/timeslot_view', $data);
    }

    public function process_reservation()
    {
        // Get form data
        $court_id = $this->input->post('court_id');
        $start_time = $this->input->post('start_time');
        $duration = $this->input->post('duration');


        $end_time = date('Y-m-d H:i:s', strtotime($start_time) + 3600 * $duration);


        if ($this->isCourtAvailable($court_id, $start_time, $end_time)) {

            $this->insertReservation($court_id, $start_time, $end_time);


            redirect('reservation/success');
        } else {

            echo 'Court is not available for the specified duration.';
        }
    }

    private function isCourtAvailable($court_id, $start_time, $end_time)
    {
        // Implement the logic to check court availability in your database
        // You may perform a database query here to check for overlapping reservations
        // Return true if the court is available, false otherwise
        // ...

        return true; // Placeholder, replace with actual logic
    }

    private function insertReservation($court_id, $start_time, $end_time)
    {

        $data = array(
            'court_id' => $court_id,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'status' => 'booked'
        );

        $this->bud_model->insert('court_schedule', $data);
    }

    public function success()
    {
        // Display a success message after successful reservation
        echo 'Reservation successful!';
    }
    public function reserve_court()
    {



        $data['courts'] = $this->bud_model->getAvailableCourts();

        $this->load->view('page/reserve_court');
    }

    //mailer
    public function webmailer_config()
    {
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_port' => '465',
            'smtp_timeout' => '7',
            'SMTPDebug' => '1',
            'SMTPAuth' => true,
            'smtp_user' => 'ojtweb_mailer@sdca.edu.ph',
            'smtp_pass' => 'sdca2022',
            'charset' => 'utf-8',
            'newline' => '\r\n',
            'mailtype' => 'html',
            'validation' => true
        );
        $this->email->initialize($config);
    }
    public function mailer_withhtml($from, $from_name, $send_to, $subject, $message)
    {
        /*  $from = 'patrickjeri.garcia@sdca.edu.ph'; */
        $this->load->library('email');
        $this->webmailer_config();
        $this->email->set_newline("\r\n");
        $this->email->from($from, $from_name);
        $this->email->to($send_to);
        $this->email->subject($subject);
        $this->email->message($message);
        if ($this->email->send()) {
            echo '<pre>' . print_r(array('status' => 'success', 'msg' => 'Email has been sent to ' . $send_to . ' (' . $send_to . ')'), 1) . '</pre>';
            redirect('page/loginview');
        } else {
            show_error($this->email->print_debugger());
            echo '<pre>' . print_r(array('status' => 'error', 'msg' => 'Failed to send Email : ' . $send_to), 1) . '</pre>';
        }
    }
    public function process_scan() {
        $referenceNumber = $this->input->post('referenceNumber');
    
        if (!empty($referenceNumber)) {
            // Insert the reference number into the database
            $this->bud_model->insert_reference_number($referenceNumber);
    
            // Send a response back to the JavaScript
            echo json_encode(['success' => true]);
        } else {
            // Handle the case when the reference number is empty
            echo json_encode(['error' => 'Reference number is empty']);
        }
    }
    
    public function generate_qrcode_and_send_email($reservationQRCode)
    {
        $this->load->library('ciqrcode');
        $this->load->model('bud_model'); // Load the QRCode_model

        // Check if the reservation with the given QR code exists in the database
        $reservationDetails = $this->bud_model->getReservationDetailsByQRCode($reservationQRCode);

        if ($reservationDetails) {
            $dataToPass = array(
                'qr_code' => $reservationDetails->qr_code,
                'id' => $reservationDetails->id,
                'reserved_datetime' => $reservationDetails->reserved_datetime,
                'status' => $reservationDetails->status,
                'user_name' => $reservationDetails->user_name,
                'user_email' => $reservationDetails->user_email,
                'court' => $reservationDetails->court,
                'sport' => $reservationDetails->sport,
                'hours' => $reservationDetails->hours
            );

            // Encode the data to pass as a JSON string
            $dataParam = json_encode($dataToPass);

            // Generate the QR code image
            $params['data'] = base_url('page/reservation_details_view') . '?data=' . urlencode($dataParam);
            $params['level'] = 'H';
            $params['size'] = 10;
            $params['savename'] = FCPATH . "application/uploads/qr_code_{$reservationQRCode}.jpg";
            $this->ciqrcode->generate($params);

            // Send the QR code in an email as an attachment
            $fromEmail = 'patrickjeri.garcia@sdca.edu.ph'; // Replace with your email
            $fromName = 'Budz Badminton Court'; // Replace with your name
            $recipientEmail = $reservationDetails->user_email;
            $subject = 'QR Code for Reservation';
            $message = 'Your Reservation is Approved. Please find the QR code for your reservation attached to this email.';

            $this->load->library('email');
            $this->webmailer_config();
            $this->email->set_newline("\r\n");
            $this->email->from($fromEmail, $fromName);
            $this->email->to($recipientEmail);
            $this->email->subject($subject);
            $this->email->message($message);
            $this->email->attach(FCPATH . "application/uploads/qr_code_{$reservationQRCode}.jpg"); // Attach the QR code image

            if ($this->email->send()) {
                // Delete the generated QR code after sending it in an email
                unlink(FCPATH . "application/uploads/qr_code_{$reservationQRCode}.jpg");

                $response = array(
                    'success' => true,
                    'message' => 'QR Code sent via email',
                    'data' => $dataToPass
                );

                $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($response));
            } else {
                // Return a JSON response for email send failure
                $response = array(
                    'success' => false,
                    'message' => 'Failed to send email with QR Code'
                );

                $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($response));
            }
        } else {
            // Return a JSON response for not found
            $response = array(
                'success' => false,
                'message' => 'Reservation not found'
            );

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
        }
    }

}