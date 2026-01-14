@extends('layouts.admin')

@section('title', 'Paramètres')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Paramètres</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Configuration du site</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="site_title">Titre du site</label>
                                <input type="text" name="site_title" id="site_title" class="form-control" value="{{ $settings['site_title'] ?? '' }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="site_description">Description du site</label>
                                <input type="text" name="site_description" id="site_description" class="form-control" value="{{ $settings['site_description'] ?? '' }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="contact_email">Email de contact</label>
                                <input type="email" name="contact_email" id="contact_email" class="form-control" value="{{ $settings['contact_email'] ?? '' }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="contact_phone">Téléphone de contact</label>
                                <input type="text" name="contact_phone" id="contact_phone" class="form-control" value="{{ $settings['contact_phone'] ?? '' }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="contact_address">Adresse de contact</label>
                        <textarea name="contact_address" id="contact_address" class="form-control">{{ $settings['contact_address'] ?? '' }}</textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="site_logo">Logo du site</label>
                                <input type="file" name="site_logo" id="site_logo" class="form-control">
                                @if(isset($settings['site_logo']))
                                    <img src="{{ asset('storage/' . $settings['site_logo']) }}" alt="Logo du site" class="img-thumbnail mt-2" width="150">
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="site_favicon">Favicon du site</label>
                                <input type="file" name="site_favicon" id="site_favicon" class="form-control">
                                @if(isset($settings['site_favicon']))
                                    <img src="{{ asset('storage/' . $settings['site_favicon']) }}" alt="Favicon du site" class="img-thumbnail mt-2" width="50">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="facebook_url">URL Facebook</label>
                                <input type="url" name="facebook_url" id="facebook_url" class="form-control" value="{{ $settings['facebook_url'] ?? '' }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="twitter_url">URL Twitter</label>
                                <input type="url" name="twitter_url" id="twitter_url" class="form-control" value="{{ $settings['twitter_url'] ?? '' }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="linkedin_url">URL LinkedIn</label>
                                <input type="url" name="linkedin_url" id="linkedin_url" class="form-control" value="{{ $settings['linkedin_url'] ?? '' }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="hidden" name="maintenance_mode" value="0">
                                    <input type="checkbox" name="maintenance_mode" id="maintenance_mode" class="custom-control-input" value="1" {{ isset($settings['maintenance_mode']) && $settings['maintenance_mode'] ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="maintenance_mode">Mode maintenance</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="hidden" name="registration_enabled" value="0">
                                    <input type="checkbox" name="registration_enabled" id="registration_enabled" class="custom-control-input" value="1" {{ isset($settings['registration_enabled']) && $settings['registration_enabled'] ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="registration_enabled">Inscriptions autorisées</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Enregistrer les paramètres</button>
                </form>
            </div>
        </div>
    </div>
@endsection