<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Page extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();

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
        $this->load->view('template/header');
        $this->load->view('page/reserve');
        

    }


    public function register()
    {
        $this->load->view('template/header');
        $this->load->view('page/register');

    }

    public function login()
    {
        $this->load->view('template/header');
        $this->load->view('page/loginview');

    }
    public function test()
    {

        $this->load->model('bud_model');
        $this->load->view('template/adminheader');
        $data['reservations'] = $this->bud_model->get_all_reservations();
        $data['ongoing_reservations'] = $this->bud_model->getOngoingReservations();
        $data['future_reservations'] = $this->bud_model->getFutureReservations();

        $this->load->view('page/test', $data);


    }
    public function reserved()
    {
        $this->load->model('bud_model');
        $this->load->view('template/adminheader');
        $data['future_reservations'] = $this->bud_model->getFutureReservations();

        $this->load->view('page/reserved', $data);

    }

    public function register_form()
    {
        $this->load->model('bud_model');
        $this->bud_model->user_registration();

    }

    public function login_form()
    {
        $this->load->model('bud_model');
        $this->bud_model->login_user();
    }

    public function main()
    {
        $this->load->model('bud_model');
        $this->load->view('template/header');
        $this->load->view('page/index');
        $this->load->view('template/footer');
    }

    public function admin()
    {
        $data['reservations'] = $this->bud_model->get_all_reservations();
        $this->load->view('page/admin', $data);

    }
    public function gallery()
    {
        $this->load->model('bud_model');
        $this->load->view('template/header');
        $this->load->view('page/gallery');

    }
    public function court_status() {
        $this->load->model('bud_model');
        $this->load->view('template/adminheader');
        $data['courts'] = $this->bud_model->get_all_courts();
        $this->load->view('page/court_status', $data);
    }


    public function logout()
    {
        $this->load->model('bud_model');
        $this->bud_model->logout();
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

    public function fetch_current_reservations()
    {
        $this->load->model('bud_model');

        $start_date_str = $this->input->post('start_date');
        $end_date_str = $this->input->post('end_date');

        if (!empty($start_date_str) && !empty($end_date_str)) {
            $start_date = new DateTime($start_date_str);
            $end_date = new DateTime($end_date_str);

            $data['ongoing'] = $this->bud_model->get_reservations_by_date_range_ongoing($start_date, $end_date);
        } else {
            $data['ongoing'] = $this->bud_model->get_all_reservations_ongoing();
        }

        $this->load->view('page/filtered_reservations', $data);
        $this->load->view('template/adminheader');
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
    
    
    
    public function moveReservations() {
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
    public function getReservations() {
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
    public function get_updated_data() {
        // Load the updated data from the model
        $updatedData = $this->bud_model->get_reservations();
        echo json_encode($updatedData);
    }
    public function calculate_hours_and_price() {
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
   
}