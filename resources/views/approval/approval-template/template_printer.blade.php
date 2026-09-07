@extends('approval.approvalCanvas')

@section('title', 'PREVIEW - SCREEN PRINTING APPROVAL SHEET')
@section('template-name', $template->name ?? 'Screen Printing Approval Sheet')
@section('form-title', 'APPROVAL SHEET PROGRAM SCREEN PRINTING')

@section('content')
<!-- INFORMASI UMUM -->
<table class="tbl-form">
    <tr>
        <td width="15%" class="bg-gray">CUSTOMER</td>
        <td width="35%"><b>{{ $template->customer ?? 'EPSON' }}</b></td>
        <td width="15%" class="bg-gray">DATE</td>
        <td width="35%">{{ date('d/m/Y') }}</td>
    </tr>
    <tr>
        <td class="bg-gray">MODEL NAME</td>
        <td>{{ $template->model ?? 'FLORENCE 24 NO' }}</td>
        <td class="bg-gray">MACHINE TYPE</td>
        <td>SCREEN PRINTER (DEK)</td>
    </tr>
    <tr>
        <td class="bg-gray">PCB NAME / NO</td>
        <td>MAIN BOARD / Rev. 02</td>
        <td class="bg-gray">PREPARED BY</td>
        <td>ENGINEERING SMT</td>
    </tr>
</table>

<!-- PARAMETER PENGECEKAN PRINTING -->
<div class="banner-title">PRINTING CONDITION & PARAMETERS</div>

<table class="tbl-form">
    <thead>
        <tr class="bg-gray text-center">
            <th width="5%">NO</th>
            <th width="45%">PARAMETER SETTING</th>
            <th width="25%">SPECIFICATION / TARGET</th>
            <th width="25%">ACTUAL VALUE</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="text-center">1</td>
            <td>PRINT SPEED</td>
            <td class="text-center">30 - 50 mm/sec</td>
            <td class="text-center fw-bold">40 mm/sec</td>
        </tr>
        <tr>
            <td class="text-center">2</td>
            <td>SQUEEGEE PRESSURE</td>
            <td class="text-center">8.0 - 10.0 kg</td>
            <td class="text-center fw-bold">9.5 kg</td>
        </tr>
        <tr>
            <td class="text-center">3</td>
            <td>SEPARATION SPEED</td>
            <td class="text-center">1.0 - 2.0 mm/sec</td>
            <td class="text-center fw-bold">1.5 mm/sec</td>
        </tr>
        <tr>
            <td class="text-center">4</td>
            <td>CLEANING FREQUENCY</td>
            <td class="text-center">Every 5 Boards</td>
            <td class="text-center fw-bold">5 Boards</td>
        </tr>
        <tr>
            <td class="text-center">5</td>
            <td>SOLDER PASTE TYPE</td>
            <td class="text-center">SAC305 Lead-Free</td>
            <td class="text-center fw-bold">SAC305</td>
        </tr>
    </tbody>
</table>

<!-- CHECKLIST QUALITY ITEM -->
<div class="banner-title">QUALITY CHECKLIST ITEMS</div>

<table class="tbl-form">
    <thead>
        <tr class="bg-gray text-center">
            <th width="5%">NO</th>
            <th width="65%">INSPECTION ITEM</th>
            <th width="15%">CHECK (✓)</th>
            <th width="15%">REMARK</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="text-center">1</td>
            <td>Solder paste coverage & alignment on PCB pads</td>
            <td class="text-center"><span class="checkbox-box">✓</span> OK</td>
            <td class="text-center">Good</td>
        </tr>
        <tr>
            <td class="text-center">2</td>
            <td>No bridging or solder paste smearing</td>
            <td class="text-center"><span class="checkbox-box">✓</span> OK</td>
            <td class="text-center">Good</td>
        </tr>
        <tr>
            <td class="text-center">3</td>
            <td>Stencil condition & aperture cleanliness check</td>
            <td class="text-center"><span class="checkbox-box">✓</span> OK</td>
            <td class="text-center">Cleaned</td>
        </tr>
    </tbody>
</table>
@endsection