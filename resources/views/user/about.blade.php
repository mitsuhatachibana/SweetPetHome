@extends('layouts.app')
@section('title','About Us')

@section('content')
<div class="container">
    <div class="p-5 rounded-4 text-white mb-4" style="background:linear-gradient(135deg,#ff7a59,#ffb26b);">
        <h1 class="fw-bold">Tentang SweetPetHome</h1>
        <p class="mb-0">Toko online kebutuhan hewan peliharaan terpercaya sejak 2023.</p>
    </div>
    <div class="row g-4">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm p-4">
                <h4 class="fw-bold">Siapa Kami?</h4>
                <p>SweetPetHome adalah platform e-commerce yang menyediakan berbagai kebutuhan hewan peliharaan seperti makanan, vitamin, obat-obatan, aksesoris, mainan, hingga perawatan. Kami berkomitmen memberikan produk original 100% dan gratis ongkir se-Indonesia.</p>
                <h5 class="fw-bold mt-3">Misi Kami</h5>
                <ul>
                    <li>Menyediakan produk berkualitas untuk hewan kesayangan.</li>
                    <li>Memberikan pengalaman belanja yang mudah & menyenangkan.</li>
                    <li>Mendukung kesehatan dan kebahagiaan hewan peliharaan.</li>
                </ul>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-4">
                <h5 class="fw-bold">Kontak</h5>
                <p class="mb-1"><i class="bi bi-envelope"></i> sphadmin@gmail.com</p>
                <p class="mb-1"><i class="bi bi-telephone"></i> 0812-3456-7890</p>
                <p class="mb-1"><i class="bi bi-geo-alt"></i> Jakarta, Indonesia</p>
                <hr>
                <h6 class="fw-bold">Pembayaran</h6>
                <small>GoPay • OVO • DANA • BCA • Mandiri • BSI • BRI • BNI • BTN • SeaBank • ShopeePay • PayLater</small>
            </div>
        </div>
    </div>
</div>
@endsection
