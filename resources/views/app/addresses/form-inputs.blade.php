@php $editing = isset($address) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.select name="waypoint_road_id" label="Road">
            @php $selected = old('waypoint_road_id', ($editing ? $address->waypoint_road_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Road</option>
            @foreach($roads as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="name"
            label="Name"
            value="{{ old('name', ($editing ? $address->name : '')) }}"
            maxlength="255"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="address"
            label="Address"
            value="{{ old('address', ($editing ? $address->address : '')) }}"
            maxlength="255"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="phone"
            label="Phone"
            value="{{ old('phone', ($editing ? $address->phone : '')) }}"
            maxlength="255"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea name="meta" label="Meta" maxlength="255" required
            >{{ old('meta', ($editing ? $address->meta : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>
</div>
