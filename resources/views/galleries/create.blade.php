<x-app-layout>
	<x-slot name="header">
		<div class="flex justify-between">
			<h2 class="font-semibold text-xl text-gray-800 leading-tight">
				{{ __('New Gallery') }}
			</h2>
		</div>
	</x-slot>

	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<form method="POST" action="{{ route('galleries.store') }}" enctype="multipart/form-data"
			      class="p-4 bg-white rounded-md space-y-1">
				@csrf
					<div>
						<label for="caption"
						       class="block mb-2 text-sm font-medium text-gray-900 ">Caption</label>
								<input type="text" id="caption" name="caption"
						       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-300 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
						       placeholder="Laravel event">
						@error('caption')
						<div class="text-sm text-red-400">{{ $message }}</div>
						@enderror
					</div>

					<div>
						<label class="block mb-2 text-sm font-medium text-gray-900 " for="file_input">Upload
							file</label>
						<input
								class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:border-gray-300 dark:placeholder-gray-400"
								id="file_input" type="file" name="image">
						@error('image')
						<div class="text-sm text-red-400">{{ $message }}</div>
						@enderror
					</div>
				<div>
					<button type="submit"
					        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Create</button>
				</div>
			</form>
		</div>
	</div>
</x-app-layout>