<div class="form-group row">
	<label for="package_topinclusions" class="col-sm-2 col-form-label">Package Themes</label>
	<div class="col-sm-10">
	<?php $packagetheme = \App\HolidayTheme::all(); ?>
		<select name="package_typetheme[]" id="package_typetheme" class="select2" multiple="multiple" data-placeholder="Select Package Theme" style="width: 100%;">
			@if(count(@$packagetheme) !== 0)
				@foreach (@$packagetheme as $packgetheme)
			<?php 
			if(isset($fetchedData->id)){
			$inclusio = explode(',', @$fetchedData->package_theme); } ?>
					<option value="{{ @$packgetheme->id }}" <?php if(isset($fetchedData->id)){ if(in_array($packgetheme->id,$inclusio)){ echo 'selected';  } } ?>>{{ @$packgetheme->name }}</option>
				@endforeach
			@endif 
		</select>								
		@if ($errors->has('package_typetheme'))
			<span class="custom-error" role="alert">
				<strong>{{ @$errors->first('package_typetheme') }}</strong>
			</span> 
		@endif
	</div>
</div>