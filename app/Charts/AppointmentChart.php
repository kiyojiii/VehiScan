<?php

namespace App\Charts;

use App\Models\Appointment;
use App\Models\User;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use ArielMejiaDev\LarapexCharts\DonutChart;
class AppointmentChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function donutChart(): DonutChart
    {
        // Retrieve all appointments
        $appointments = Appointment::all();

        // Initialize an array to store appointment counts
        $appointmentCounts = [];

        // Loop through each appointment
        foreach ($appointments as $appointment) {
            // Count the number of applicants for each appointment
            $applicantCount = $appointment->applicants()->count();
            // Add the count to the array
            $appointmentCounts[] = $applicantCount;
        }

        // Set labels for the chart
        $labels = $appointments->pluck('name')->toArray();

        // Build the donut chart
        return $this->chart->donutChart()
            ->setTitle('Applicants per Appointment')
            ->setLabels($labels)
            ->addData($appointmentCounts);
    }

    public function lineChart(): \ArielMejiaDev\LarapexCharts\LineChart
    {
        return $this->chart->lineChart()
            ->setTitle('Top 3 scorers of the team.')
            ->setSubtitle('Season 2021.')
            ->addData('Sales', [20, 24, 30]) // Provide a string as the first argument
            ->setLabels(['Player 7', 'Player 10', 'Player 9']);
    }
    
}
