<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->database();
        
    }
    public function landing_page() {

        $this->load->view('template/header');
        $this->load->view('page/landing_page');
        $this->load->view('template/footer');
    }
    public function history() {

        $this->load->model('bud_model');
        $data['declined'] = $this->bud_model->get_all_declined();
        $this->load->view('page/history', $data);
        $this->load->view('template/adminheader');
        
    }
    public function reserve() {
        $this->load->view('template/header');
        $this->load->view('page/reserve');
        $this->load->view('template/footer');
    }

    public function view_reservations() {
        $this->load->view('template/header');
        $this->load->view('page/view-reservation');
        $this->load->view('template/footer');
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
    public function register_form() {
        $this->load->model('bud_model');
        $this->bud_model->user_registration();
        
    }
    
    public function login_form() {
        $this->load->model('bud_model');
        $this->bud_model->login_user();
    }
    
    public function main() {
        $this->load->model('bud_model');
        $this->load->view('template/header');
		$this->load->view('page/index');
        $this->load->view('template/footer');
    }

    public function admin() {
        $data['reservations'] = $this->bud_model->get_all_reservations(); 
        $this->load->view('page/admin', $data);
    }
    


    public function logout()
    {
      $this->load->model('bud_model');
      $this->bud_model->logout();
    }
    
    public function submit_reserve() {
        $this->load->model('bud_model');
    
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $userDateTime = $this->input->post('datetime'); 
            
            $userTimezone = new DateTimeZone('Asia/Manila');
    
            $dateTime = new DateTime($userDateTime, $userTimezone);
 
            $utcDatetime = $dateTime->format('Y-m-d H:i:s');
            
            $data = array(
                'reserved_datetime' => $utcDatetime
            );
            
            
            if ($this->db->insert('reservations', $data)) {
                echo "Reservation created successfully";
            } else {
                echo "Error creating reservation";
            }
        }
    }
    
    
    public function timetable() {
        $this->load->model('bud_model');
        $data['reservations'] = $this->bud_model->get_all_reservations();
        $this->load->view('page/timetable', $data);
        $this->load->view('template/adminheader');
    }
    public function approved() {
        $this->load->model('bud_model');
        $data['today'] = $this->bud_model->get_all_approved();
        $this->load->view('page/approved', $data);
        $this->load->view('template/adminheader');
    }


    
    public function get_reservations() {
        $this->load->model('bud_model');
        
        $reservations = $this->bud_model->getReservations();
    
        $events = [];
        foreach ($reservations as $reservation) {
            $randomColor = $this->generateRandomColor(); // Call a function to generate a random color
            
            $events[] = [
                'title' => 'Reserved',
                'start' => $reservation->reserved_datetime,
                'color' => $randomColor, // Use the random color here
                'popoverHtml' => 'Reservation Details:<br>' .
                    'Date: ' . date('Y-m-d', strtotime($reservation->reserved_datetime)) . '<br>' .
                    'Time: ' . date('H:i', strtotime($reservation->reserved_datetime)),
                'eventDisplay' => 'popover'
            ];
        }
    
        header('Content-Type: application/json');
        echo json_encode($events);
    }
    
    // Function to generate a random color
    private function generateRandomColor() {
        $letters = '0123456789ABCDEF';
        $color = '#';
        for ($i = 0; $i < 6; $i++) {
            $color .= $letters[rand(0, 15)];
        }
        return $color;
    }
    
        public function get_approved_reservations() {
            // Load the Reservations_model
            $this->load->model('bud_model');

            // Fetch approved reservations from the model
            $approved_reservations = $this->bud_model->get_a_reservations();

            // Return the JSON response
            $this->output->set_content_type('application/json')->set_output(json_encode($approved_reservations));
        }
        public function get_reservations_for_date() {
            $date = $this->input->post('date');
            $this->load->model('bud_model');
            $reservations = $this->bud_model->getReservationsForDate($date);
            header('Content-Type: application/json');
            echo json_encode($reservations);
        }
        public function approve_reservation($reservationId) {
            $this->load->model('bud_model');
            $reservation = $this->bud_model->getReservation($reservationId);
    
            if ($reservation->status === 'pending') {
                // Update the status to 'approved' in the "reservations" table
                $this->bud_model->updateStatus($reservationId, 'approved');
    
                // Transfer approved reservation to the "today" table
                $this->bud_model->transferToToday($reservation);

                // Update status in the "today" table
                $this->bud_model->updateTodayStatus($reservation->reserved_datetime, 'approved');
    
                // Remove the reservation from the "reservations" table
                $this->bud_model->removeReservation($reservationId);
    
                $response = array('status' => 'success');
            } else {
                $response = array('status' => 'error', 'message' => 'Reservation not pending.');
            }
    
            // Send the response as JSON
            $this->output->set_content_type('application/json')->set_output(json_encode($response));
        }
        
        
        public function decline_reservation($reservationId) {
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

        
    
}
         
