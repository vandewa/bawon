<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Vendor;
use Livewire\Component;
use App\Models\Pengajuan;
use App\Models\PaketKegiatan;
use App\Models\PaketPekerjaan;
use Asantibanez\LivewireCharts\Models\PieChartModel;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;

class Dashboard extends Component
{
    public $columnChartModel;
    public $pieChartModel;

    public function mount()
    {
        // Dummy Data Count
        $totalUsers = User::count();
        $totalVendors = Vendor::count();
        $totalPaket = PaketPekerjaan::count();
        $totalKegiatan = PaketKegiatan::count();

        // Column Chart Example
        // $this->columnChartModel = (new ColumnChartModel())
        //     ->setTitle('Statistik Data Utama')
        //     ->addColumn('User', $totalUsers, '#4CAF50')
        //     ->addColumn('Vendor', $totalVendors, '#2196F3')
        //     ->addColumn('Paket', $totalPaket, '#FFC107')
        //     ->addColumn('Kegiatan', $totalKegiatan, '#F44336');

        // // Pie Chart Example
        // $pengajuanStatuses = PaketKegiatan::selectRaw('status, count(*) as total')
        //     ->groupBy('status')
        //     ->pluck('total', 'status')
        //     ->toArray();

        // $pieChart = new PieChartModel();
        // $pieChart->setTitle('Distribusi Status Pengajuan');

        // foreach ($pengajuanStatuses as $status => $count) {
        //     $pieChart->addSlice($status ?? 'Tidak diketahui', $count, '#' . substr(md5($status), 0, 6));
        // }

        // $this->pieChartModel = $pieChart;
    }

    public function render()
    {
        return view('livewire.dashboard', [
            'columnChartModel' => $this->columnChartModel,
            'pieChartModel' => $this->pieChartModel,
        ]);
    }
}
