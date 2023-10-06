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



    }
    public function landing_page()
    {

        // Load the view and pass the $data array to it
        $this->load->view('template/header'); // Assuming the view file is located in 'application/views/template/header.php'
        // Load other content for the landing page as needed

        $this->load->view('page/landing_page');


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



      
        $this->load->view('template/header');
        $this->load->view('page/reserve');


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
        $this->form_validation->set_error_delimiters('<div class="error"alert alert-dark"', '</div>');
        // Form validation rules
        $this->form_validation->set_rules('name', 'Full Name', 'trim|required');
        $this->form_validation->set_rules('email', 'E-Mail Address', 'trim|required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('con_password', 'Confirm Password', 'trim|required|matches[password]');

        if ($this->form_validation->run() === FALSE) {
            // Form validation failed, display the registration form again
            $this->load->view('page/register');
        } else {
            // Form validation passed, proceed with user registration
            $data = array(
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password'),
                // Store the plain password
                'role' => 'user',
                // Default role for a new user
            );


            // Check if the email already exists
            if ($this->bud_model->check_email_exist($data['email'])) {
                $this->session->set_flashdata('error', 'Email already exists.');
                redirect('page/register');
            }

            // Register the user
            if ($this->bud_model->register_user($data)) {
                $this->session->set_flashdata('success', 'Registered successfully.');
                redirect('page/loginview');
            } else {
                $this->session->set_flashdata('error', 'Registration failed.');
                redirect('page/register');
            }
        }
    }


    public function main()
    {
        if (!$this->session->userdata('id')) {
            // If not logged in, redirect to the login page
            redirect('page/loginview');
        }
        $this->load->model('bud_model');
        $this->load->view('template/header');
        $data['name'] = $this->session->userdata('name');
        $this->load->view('page/index', $data);
        $this->load->view('template/footer');
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
        $data['reservations'] = $this->bud_model->get_all_reservations();
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
            $userDateTime = $this->input->post('datetime');
            $court = $this->input->post('court');
            $sport = $this->input->post('sport');


            $userTimezone = new DateTimeZone('Asia/Manila');
            $dateTime = new DateTime($userDateTime, $userTimezone);
            $utcDatetime = $dateTime->format('Y-m-d H:i:s');

            $data = array(
                'reserved_datetime' => $utcDatetime,
                'court' => $court,
                'sport' => $sport
            );

            if ($this->db->insert('reservations', $data)) {
                echo "Reservation created successfully";
            } else {
                echo "Error creating reservation";
            }
        }
    }



    public function timetable()
    {
         // Check if the user is logged in
         if (!$this->session->userdata('id')) {
            // If not logged in, redirect to the login page
            redirect('page/loginview');
        }

        // Get the user's role from the session
        $user_role = $this->session->userdata('role');

        // Check if the user's role is 'admin'
        if ($user_role === 'admin') {
            // If the user is an admin, redirect them to the admin page
            redirect('page/admin'); // Redirect to the admin page
        } elseif ($user_role === 'user') {
            // If the user is a regular user, redirect them to a landing page
            redirect('page/landing_page'); // Redirect to a landing page for regular users
        } else {
            // Handle other cases as needed
            redirect('page/access_denied'); // Redirect to an "Access Denied" page or handle it as needed
        }
        $this->load->model('bud_model');
        $data['reservations'] = $this->bud_model->get_all_reservations();
        $data['ongoing_reservations'] = $this->bud_model->getOngoingReservations();
        $data['future_reservations'] = $this->bud_model->getFutureReservations();
        $this->load->view('page/timetable', $data);
        $this->load->view('template/adminheader');
    }

    public function approved()
    {
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
            $response = array('status' => 'error', 'message' => 'Reservation not pending.');
        }

        // Send the response as JSON
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
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
        $newReservedDatetime = $this->input->post('newReservedDatetime');
        $newCourt = $this->input->post('court');
        $newSport = $this->input->post('sport');

        // Call the model to update the reservation
        $result = $this->bud_model->updateReservation($reservationId, $newReservedDatetime, $newCourt, $newSport);

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
    public function update_status($court_id)
    {
        $new_status = $this->input->post('status');
        // Perform validation on $new_status if needed

        // Update the court status in your database
        $this->bud_model->update_status($court_id, $new_status);

        // Redirect back to the page displaying the courts
        redirect('courts');
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
        redirect('courts');
    }

    public function signup()
    {
        // Handle user registration here
        // Validation, form submission, user creation, etc.

        $data = [
            'username' => $this->input->post('username'),
            'email' => $this->input->post('email'),
            'password' => $this->input->post('password'),
            PASSWORD_DEFAULT,
        ];

        $user_id = $this->bud_model->create_with_verification_token($data);

        if ($user_id) {
            // Send an email with a verification link containing the token
            $verification_link = site_url('auth/verify/' . $data['email_verification_token']);
            // Send email with $verification_link to the user
            // Example: You can use CodeIgniter's Email Library for sending emails.
        }
    }
    public function verify($token)
    {
        if ($this->bud_model->verify_email($token)) {
            // Email verified successfully, show a success message
            // You can also automatically log the user in here if needed
        } else {
            // Invalid or expired token, show an error message
        }


    }
    public function registe()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Form validation rules
            $this->form_validation->set_rules('name', 'Full Name', 'trim|required');
            $this->form_validation->set_rules('email', 'E-Mail Address', 'trim|required|valid_email|is_unique[users.email]');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
            $this->form_validation->set_rules('con_password', 'Confirm Password', 'trim|required|matches[password]');

            if ($this->form_validation->run()) {
                // Form validation passed, insert the user into the database
                $data = array(
                    'name' => $this->input->post('name'),
                    'email' => $this->input->post('email'),
                    'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                    // Hash the password
                    'role' => 'user',
                    // Default role for a new user
                );

                $this->User_Model->register_user($data);

                // Optionally, you can add a success message here
                redirect('page/loginview'); // Redirect to the login page after successful registration
            }
        }

        // Load the registration view
        $this->load->view('page/register');
    }

    public function sampleTestEmail()
    {

        $First_Name = $this->session->userdata('First_Name');
        $Middle_Name = $this->session->userdata('Middle_Name');
        $Last_Name = $this->session->userdata('Last_Name');
        //$Course = $this->session->userdata('Course');
        //$YearLevel = $this->session->userdata('YearLevel');
        $Address_No = $this->session->userdata('Address_No');
        $Address_Street = $this->session->userdata('Address_Street');
        $Address_Subdivision = $this->session->userdata('Address_Subdivision');
        $Address_Barangay = $this->session->userdata('Address_Barangay');
        $Address_City = $this->session->userdata('Address_City');
        $Address_Province = $this->session->userdata('Address_Province');
        $Email = $this->session->userdata('Email');
        $Cp_No = $this->session->userdata('Cp_No');
        $Tel_No = $this->session->userdata('Tel_No');
        $Student_Number = $this->session->userdata('Student_Number');
        //$logged_in = $this->session->userdata('logged_in');


        $cart_data = $this->Cart_model->getProductsInPayment($Student_Number);

        // Initialize an array to store product names
        //$product_names = array();
        //$product_quantities = array();
        //$product_totals = array();

        // Iterate through products and extract product names
        foreach ($cart_data as $product) {
            $cID = $product['c_id'];
            $product_names[$cID] = $product['transactionItem'];
            $product_quantities[$cID] = $product['quantity'];
            $product_totals[$cID] = $product['total_price'];
        }

        $address = array(
            'Address_No' => $this->session->userdata('Address_No'),
            'Address_Street' => $this->session->userdata('Address_Street'),
            'Address_Subdivision' => $this->session->userdata('Address_Subdivision'),
            'Address_Barangay' => $this->session->userdata('Address_Barangay'),
            'Address_City' => $this->session->userdata('Address_City'),
            'Address_Province' => $this->session->userdata('Address_Province')
        );

        $final_price = array_sum($product_totals); // Calculate the sum of product_totals

        $student_name = $First_Name . '' . $Middle_Name . ' ' . $Last_Name;
        $from = 'jfabregas@sdca.edu.ph';
        $from_name = 'ICT';
        $send_to = $Email;
        $subject = 'Test Email';
        // $message = 'This is a test email';
        $message = 'email/test';
        $add_data = array(
            'first_name' => $First_Name,
            'middle_name' => $Middle_Name,
            'last_name' => $Last_Name,
            'address' => $address,
            'product_names' => $product_names,
            'product_quantities' => $product_quantities,
            'product_totals' => $product_totals,
            'final_price' => $final_price

        );
        $this->sdca_mailer->send_email($student_name, $from, $from_name, $send_to, $subject, $message, $add_data);
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
                        'role' => 'admin' // Add role information to the session
                    );
                    $this->session->set_userdata($user_data);
                    redirect('page/admin'); // Replace 'admin/dashboard' with your admin dashboard URL
                } else {
                    // Regular user, redirect to user dashboard or main page
                    $user_data = array(
                        'id' => $validate->id,
                        'name' => $validate->name,
                        'role' => 'user' // Add role information to the session
                    );
                    $this->session->set_userdata($user_data);
                    redirect('page/main'); // Replace 'page/main' with your user dashboard or main page URL
                }
            } else {
                $this->session->set_flashdata('error', 'Invalid login details. Please try again.');
                redirect('page/loginview');
            }
        } else {
            $this->load->view('page/loginview'); // Display the login view
        }
    }




    public function logout()
    {
        $this->session->unset_userdata('user_id');
        $this->session->sess_destroy();
        redirect('page/loginview');
    }

}