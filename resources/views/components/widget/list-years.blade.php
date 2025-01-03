 <div>
     @php
         $years = App\Livewire\Helpers\Date\DateFormatHelper::getYears();
     @endphp
     @props(['error'])
     <select {{ $attributes }} class="form-control  @error($error) is-invalid @enderror">
         <option value="">Choisir</option>
         @foreach ($years as $year)
             <option value="{{ $year }}">{{ $year }}</option>
         @endforeach
     </select>
 </div>
