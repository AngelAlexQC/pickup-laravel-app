@php $editing = isset($road) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="name"
            label="Name"
            value="{{ old('name', ($editing ? $road->name : '')) }}"
            maxlength="255"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="address_start_id" label="Address Start">
            @php $selected = old('address_start_id', ($editing ? $road->address_start_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Address</option>
            @foreach($addresses as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="address_end_id" label="Address End">
            @php $selected = old('address_end_id', ($editing ? $road->address_end_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Address</option>
            @foreach($addresses as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea name="meta" label="Meta" maxlength="255" required
            >{{ old('meta', ($editing ? $road->meta : '')) }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="price"
            label="Price"
            value="{{ old('price', ($editing ? $road->price : '')) }}"
            max="255"
            step="0.01"
            required
        ></x-inputs.number>
    </x-inputs.group>
</div>
