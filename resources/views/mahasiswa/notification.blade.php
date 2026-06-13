@extends('layouts.mahasiswa')
@section('title', 'Notifikasi - SCMS')

@section('content')
<div class="w-full max-w-4xl mx-auto pt-8 pb-14 px-4 sm:px-6 lg:px-8 relative">
    
    <div class="flex flex-row items-center justify-between mb-6">
        <h1 class="text-[#191b23] font-['Manrope-Bold',_sans-serif] text-2xl font-bold tracking-[-0.48px]">
            Your Updates
        </h1>
        <button class="bg-[#ededf9] hover:bg-[#dbe1ff] transition rounded-full py-2 px-4 flex items-center justify-center">
            <span class="text-[#004ac6] font-['Manrope-SemiBold',_sans-serif] text-[13px] font-semibold tracking-[0.65px]">
                Mark all as read
            </span>
        </button>
    </div>

    <div class="bg-white rounded-xl border border-[rgba(195,198,215,0.30)] shadow-[0_4px_20px_rgba(0,0,0,0.04)] overflow-hidden flex flex-col">
        
        <div class="bg-[#faf8ff] border-b border-[rgba(195,198,215,0.30)] p-6 flex flex-row gap-4 items-start relative hover:bg-[#f3f3fe] transition cursor-pointer group">
            <div class="bg-[#e5edfa] group-hover:bg-[#d0e1fb] transition rounded-full w-10 h-10 flex items-center justify-center shrink-0">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M0 20V2C0 1.45 0.195833 0.979167 0.5875 0.5875C0.979167 0.195833 1.45 0 2 0H18C18.55 0 19.0208 0.195833 19.4125 0.5875C19.8042 0.979167 20 1.45 20 2V14C20 14.55 19.8042 15.0208 19.4125 15.4125C19.0208 15.8042 18.55 16 18 16H4L0 20ZM3.15 14H18V2H2V15.125L3.15 14ZM2 14V2V14Z" fill="#004AC6"/></svg>
            </div>
            <div class="flex flex-col gap-1 flex-1">
                <h3 class="text-[#191b23] font-['Manrope-SemiBold',_sans-serif] text-base font-semibold">Admin replied to #CMP-102</h3>
                <p class="text-[#434655] font-['Manrope-Regular',_sans-serif] text-sm">"We have reviewed your request regarding the dormitory maintenance..."</p>
                <span class="text-[#434655] font-['Manrope-SemiBold',_sans-serif] text-[13px] font-semibold tracking-[0.65px] mt-1">Just now</span>
            </div>
            <div class="bg-[#004ac6] rounded-full w-2.5 h-2.5 shrink-0 mt-2"></div>
            <div class="bg-[#004ac6] w-1 absolute left-0 top-0 bottom-0 rounded-r-full"></div>
        </div>

        <div class="bg-white border-b border-[rgba(195,198,215,0.30)] p-6 flex flex-row gap-4 items-start relative hover:bg-gray-50 transition cursor-pointer group">
            <div class="bg-[#e1e2ed] group-hover:bg-[#d1d2dd] transition rounded-full w-10 h-10 flex items-center justify-center shrink-0">
                <svg width="16" height="20" viewBox="0 0 16 20" fill="none"><path d="M4 16H12V14H4V16ZM4 12H12V10H4V12ZM2 20C1.45 20 0.979167 19.8042 0.5875 19.4125C0.195833 19.0208 0 18.55 0 18V2C0 1.45 0.195833 0.979167 0.5875 0.5875C0.979167 0.195833 1.45 0 2 0H10L16 6V18C16 18.55 15.8042 19.0208 15.4125 19.4125C15.0208 19.8042 14.55 20 14 20H2ZM9 7V2H2V18H14V7H9ZM2 2V7V2V7V18V2Z" fill="#434655"/></svg>
            </div>
            <div class="flex flex-col gap-1 flex-1 opacity-80">
                <h3 class="text-[#191b23] font-['Manrope-SemiBold',_sans-serif] text-base font-semibold">New document uploaded for #CMP-098</h3>
                <p class="text-[#434655] font-['Manrope-Regular',_sans-serif] text-sm">Admin has attached 'maintenance_report.pdf' to your ticket.</p>
                <span class="text-[#434655] font-['Manrope-SemiBold',_sans-serif] text-[13px] font-semibold tracking-[0.65px] mt-1">Yesterday</span>
            </div>
        </div>

        <div class="bg-white border-b border-[rgba(195,198,215,0.30)] p-6 flex flex-row gap-4 items-start relative hover:bg-gray-50 transition cursor-pointer group">
            <div class="bg-[rgba(255,218,214,0.30)] group-hover:bg-[rgba(255,218,214,0.60)] transition rounded-full w-10 h-10 flex items-center justify-center shrink-0">
                <svg width="4" height="18" viewBox="0 0 4 18" fill="none"><path d="M2 18C1.45 18 0.979167 17.8042 0.5875 17.4125C0.195833 17.0208 0 16.55 0 16C0 15.45 0.195833 14.9792 0.5875 14.5875C0.979167 14.1958 1.45 14 2 14C2.55 14 3.02083 14.1958 3.4125 14.5875C3.80417 14.9792 4 15.45 4 16C4 16.55 3.80417 17.0208 3.4125 17.4125C3.02083 17.8042 2.55 18 2 18ZM0 12V0H4V12H0Z" fill="#BA1A1A"/></svg>
            </div>
            <div class="flex flex-col gap-1 flex-1 opacity-80">
                <h3 class="text-[#191b23] font-['Manrope-SemiBold',_sans-serif] text-base font-semibold">System Maintenance Alert</h3>
                <p class="text-[#434655] font-['Manrope-Regular',_sans-serif] text-sm">SCMS will be down for scheduled maintenance on Sunday from 02:00 to 04:00.</p>
                <span class="text-[#434655] font-['Manrope-SemiBold',_sans-serif] text-[13px] font-semibold tracking-[0.65px] mt-1">Oct 24, 2023</span>
            </div>
        </div>

        <div class="p-4 flex justify-center bg-gray-50">
            <button class="bg-white border border-[#c3c6d7] rounded-lg py-2 px-6 text-[#191b23] font-['Manrope-SemiBold',_sans-serif] text-[13px] font-semibold tracking-[0.65px] hover:bg-gray-100 transition shadow-sm">
                Load More
            </button>
        </div>

    </div>
</div>
@endsection