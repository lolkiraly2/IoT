<x-print-layout
  type="module_names.devices.label"
  name="{{ $record->name }}"
  route="{{ route('filament.admin.resources.devices.view', $record->id) }}"
  >
</x-print-layout>