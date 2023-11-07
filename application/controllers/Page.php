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
        $subject = 'Email Verification';
        $message = 'Click the following link to verify your email address: ' . base_url('verification?token=' . $verificationToken);
        $from_name = "Budz Badminton Court";
        $from = "patrickjeri.garcia@sdca.edu.ph";
        $add_data = array();

        // Now, you can use the provided email and verification token to send the verification email
        $this->mailer_withhtml($from, $from_name, $email, $subject, $message, $add_data);
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
        /*  $data['reservations'] = $this->bud_model->get_all_reservations();
         $this->load->view('page/admin', $data); */

        $data['futureReservations'] = $this->bud_model->getrepReservations();

        // Load the HTML template and pass data
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
            /*   $image = $_FILES['referenceNum'];

              // Set the upload path and file name
              $uploadPath = './payment/';
              $fileName = basename($image['name']);
              $filePath = $uploadPath . $fileName;

              // Move the uploaded file to the upload path
              if (move_uploaded_file($image['tmp_name'], $filePath)) {
                  echo "File uploaded successfully";
              } else {
                  echo "Error uploading file";
              } */

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
                /*  'image' => $filePath, */
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

                // Send an email notification to the user
                $from = 'ojtweb_mailer@sdca.edu.ph'; // Set your sender email address
                $from_name = 'Budz Badminton Court'; // Set your sender name
                $user_email = $reservation->user_email; // User's email
                $subject = 'Reservation Approved';
                $message = 'Your reservation has been approved.';

                // Call your mailer function to send the email
                $this->mailer_withhtml($from, $from_name, $user_email, $subject, $message);
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



    public function sendReservationApprovalEmail()
    {
        $subject = 'Reservation Approved';
        $message = 'Your reservation has been approved.';
        $from_name = "Budz Badminton Court";
        $from = "patrickjeri.garcia@sdca.edu.ph";
        $email = 'garciapatrick341@gmail.com';
        $add_data = array();



        $this->mailer_withhtml($from, $from_name, $email, $subject, $message, $add_data);
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

    // In your controller
    public function user_management()
    {
        // Load the user data from your model
        $data['users'] = $this->bud_model->getUsers(); // Replace with your actual model and method

        // Load the view and pass the data
        $this->load->view('page/user_management', $data);
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


    public function receipt_view($reservation_id)
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
        $this->load->view('receipt_view');
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
        } else {
            show_error($this->email->print_debugger());
            echo '<pre>' . print_r(array('status' => 'error', 'msg' => 'Failed to send Email : ' . $send_to), 1) . '</pre>';
        }
    }
    public function nohtml()
    {
        $this->load->view('page/nohtml');
    }

}