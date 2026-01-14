<!-- Alertes flash -->
@if(session('success'))
    <div class="alert-auto-hide bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r-lg">
        <div class="flex items-center">
            <i class="fas fa-check-circle text-green-500 mr-3"></i>
            <div class="flex-1">
                {{ session('success') }}
            </div>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-green-700 hover:text-green-900">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="alert-auto-hide bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r-lg">
        <div class="flex items-center">
            <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
            <div class="flex-1">
                {{ session('error') }}
            </div>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-red-700 hover:text-red-900">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
@endif

@if(session('warning'))
    <div class="alert-auto-hide bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6 rounded-r-lg">
        <div class="flex items-center">
            <i class="fas fa-exclamation-triangle text-yellow-500 mr-3"></i>
            <div class="flex-1">
                {{ session('warning') }}
            </div>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-yellow-700 hover:text-yellow-900">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
@endif

<!-- Validation errors -->
@if($errors->any())
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r-lg">
        <div class="flex items-center">
            <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
            <div class="flex-1">
                <h4 class="font-bold mb-2">Veuillez corriger les erreurs suivantes :</h4>
                <ul class="list-disc pl-5 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif