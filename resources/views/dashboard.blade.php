@extends('layouts.dashboard')

@section('content')
<style>
    .dashboard-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    .stat-card {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .stat-card h3 {
        font-size: 1.2rem;
        color: #333;
        margin-bottom: 10px;
    }

    .stat-card p {
        font-size: 1.5rem;
        font-weight: bold;
        color: #007bff;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }
    /* Dashboard Charts */
.dashboard-charts {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.chart {
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
    transition: transform 0.3s, box-shadow 0.3s;
}

.chart h3 {
    font-size: 1.2rem;
    color: #333;
    margin-bottom: 10px;
}

.chart:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

/* Dashboard Widgets */
.dashboard-widgets {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.widget {
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s, box-shadow 0.3s;
}

.widget h3 {
    font-size: 1.2rem;
    color: #333;
    margin-bottom: 10px;
}

.widget p, .widget ul {
    font-size: 1rem;
    color: #555;
}

.widget ul {
    list-style: none;
    padding: 0;
}

.widget ul li {
    background: #f4f4f4;
    padding: 10px;
    margin: 5px 0;
    border-radius: 6px;
}

.widget:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

</style>
<div class="dashboard-stats">
    <div class="stat-card">
        <h3>Doanh thu</h3>
        <p>40,886,200 VND</p>
    </div>
    <div class="stat-card">
        <h3>Hợp đồng mới</h3>
        <p>275,800</p>
    </div>
    <div class="stat-card">
        <h3>Lượt truy cập</h3>
        <p>106,120</p>
    </div>
    <div class="stat-card">
        <h3>Hoạt động người dùng</h3>
        <p>80,600</p>
    </div>
</div>

<div class="dashboard-charts">
    <div class="chart">
        <h3>Đơn hàng</h3>
        <canvas id="ordersChart"></canvas>
    </div>
    <div class="chart">
        <h3>Doanh thu theo tháng</h3>
        <canvas id="revenueChart"></canvas>
    </div>
</div>

<div class="dashboard-widgets">
    <div class="widget">
        <h3>Tin nhắn mới</h3>
        <p>Bạn có 22 tin nhắn chưa đọc</p>
    </div>
    <div class="widget">
        <h3>Danh sách công việc</h3>
        <ul>
            <li>Đánh Nhau</li>
            <li>HEHEHEHEH</li>
            <li>Gửi tài liệu</li>
        </ul>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('ordersChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr'],
            datasets: [{
                label: 'Số lượng đơn hàng',
                data: [500, 700, 800, 600],
                backgroundColor: 'rgba(54, 162, 235, 0.6)'
            }]
        }
    });
</script>
@endsection
