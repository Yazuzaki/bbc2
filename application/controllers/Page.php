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
        $this->load->view('template/footer');
    }
    public function history()
    {

        $this->load->model('bud_model');
        $data['declined'] = $this->bud_model->get_all_declined();
        $this->load->view('page/history', $data);
        $this->load->view('template/adminheader');

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
        $this->load->view('template/adminheader');
    }



    public function logout()
    {
        $this->load->model('bud_model');
        $this->bud_model->logout();
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
    public function filtered_reservations()
    {
        $this->load->model('bud_model');
        $data['reservations'] = $this->bud_model->get_reservations_by_date_range();
        $data['ongoing_reservations'] = $this->bud_model->getOngoingReservations();
        $data['future_reservations'] = $this->bud_model->getFutureReservations();
        $this->load->view('page/filtered_reservations', $data);
        $this->load->view('template/adminheader');
    }
    public function approved()
    {
        $this->load->model('bud_model');
        $data['today'] = $this->bud_model->get_all_approved();
        $this->load->view('page/approved', $data);
        $this->load->view('template/adminheader');
    }



    public function get_reservations()
    {
        $this->load->model('bud_model');

        $reservations = $this->bud_model->getReservations();

        $events = [];
        foreach ($reservations as $reservation) {
            $randomColor = $this->generateRandomColor();

            $events[] = [
                'title' => 'Reserved',
                'start' => $reservation->reserved_datetime,
                'color' => $randomColor,
                'popoverHtml' => 'Reservation Details:<br>' .
                'Date: ' . date('Y-m-d', strtotime($reservation->reserved_datetime)) . '<br>' .
                'Time: ' . date('H:i', strtotime($reservation->reserved_datetime)),

            ];
        }

        header('Content-Type: application/json');
        echo json_encode($events);
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

    public function approve_reservation($reservationId)
    {
        $this->load->model('bud_model');
        $reservation = $this->bud_model->getReservation($reservationId);

        if ($reservation->status === 'pending') {
            // Check if the reservation date is today
            $today = date('Y-m-d');
            $reservationDate = date('Y-m-d', strtotime($reservation->reserved_datetime));

            if ($reservationDate === $today) {
                // If it's today, update status to 'ongoing' and transfer to the "ongoing" table
                $this->bud_model->updateStatus($reservationId, 'approved');
                $this->bud_model->transferToOngoing($reservation);
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
    public function fetch_reservations()
    {
        $this->load->model('bud_model');

        $start_date_str = $this->input->post('start_date');
        $end_date_str = $this->input->post('end_date');

        if (!empty($start_date_str) && !empty($end_date_str)) {
            $start_date = new DateTime($start_date_str);
            $end_date = new DateTime($end_date_str);

            $data['reservations'] = $this->bud_model->get_reservations_by_date_range($start_date, $end_date);
        } else {
            $data['reservations'] = $this->bud_model->get_all_reservations();
        }

        $this->load->view('page/filtered_reservations', $data);
        $this->load->view('template/adminheader');
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
    public function cancel_reservation($reservationId)
    {
        // Check if the user is logged in or authorized to perform this action if needed

        // Update the reservation status
        $result = $this->Reservation_model->cancel_reservation($reservationId);

        if ($result) {
            $response = array('status' => 'success', 'message' => 'Reservation has been canceled.');
        } else {
            $response = array('status' => 'error', 'message' => 'Failed to cancel reservation.');
        }

        // Return the response as JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}