@extends('errors::layout')

@section('title', __('Too Many Requests'))
@section('code', '429')
@section('message', __('Maaf, anda telah mencuba terlalu kerap.'))
