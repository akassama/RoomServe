<!-- Thead column -->
<script id="table-thead-column-template" type="text/x-handlebars-template">
	<th class='col-{{name}}'
		data-name='{{name}}' 
		data-order-name='{{#if order_name}} {{order_name}} {{else}} {{name}} {{/if}}' 
		width='{{width}}%'
		{{#ifEquals type 'actions'}} data-priority="1" {{/ifEquals}}
	>
		{{title}}
	</th>
</script>


<!-- Quick stats -->
<script id="table-quick-stats-template" type="text/x-handlebars-template">
	<ul class="pls_quick-stats" data-count="{{count}}">
		<button class="pls_quick-stat-help" data-tooltip title="<?=lang('table_stats_help')?>"></button>

		{{#each stats}}
			<li class="color-{{color}}">
				<a href="#" data-preset="{{preset}}" class="link {{#ifEquals preset ../active_preset}} active {{/ifEquals}}">
					<span class="title">{{title}}</span>
					<div class="stat" id="quick_stat-{{name}}" data-counter="true">{{result}}</div>
				</a>
			</li>
		{{/each}}
	</ul>
</script>


<!-- Table filter - group title -->
<script id="table-filter-group-title-template" type="text/x-handlebars-template">
	<h4 class="pls_form-title">{{group_title}}</h4>
</script>


<!-- Table filter - buttons -->
<script id="table-filter-buttons-template" type="text/x-handlebars-template">
	<hr class="pls_divider">
	<div class="pls_filter-buttons">
		<button class="pls_button color-grey" type="button" data-filter-clear><?=lang('table_btn_clear')?></button>
		<button class="pls_button color-info" type="submit"><?=lang('table_btn_filter')?></button>
	</div>
</script>


<!-- Table filter - field wrap -->
<script id="table-filter-field-wrap-template" type="text/x-handlebars-template">
	<div class="pls_field-wrap"><label class="pls_field-label">{{title}}</label>{{{field}}}</div>
</script>


<!-- Table filter - input -->
<script id="table-filter-input-template" type="text/x-handlebars-template">
	<div class="pls_field">
		<input type="text" class="pls_input {{#ifEquals field.type 'date'}} pls_datepicker {{/ifEquals}}" 
			name="filter[{{field.name}}]" 
			value="{{field.value}}" 
			{{all_attr}} 
			{{#ifEquals field.type 'email'}} data-rule-email="true" {{/ifEquals}}
		/>
	</div>
</script>


<!-- Table filter - select -->
<script id="table-filter-select-template" type="text/x-handlebars-template">
	<div class="pls_field">
		<select class="pls_selectpicker" name="filter[{{field.name}}]" {{{all_attr}}} data-value="{{field.value}}" {{#if field.url}} data-url="{{field.url}}" {{/if}}>
			{{#each field.options}}
				<option value="{{@key}}" {{#ifEquals ../field.selected @key}} selected {{/ifEquals}}>{{this}}</option>
			{{/each}}
		</select>
	</div>
</script>


<!-- Table filter - switcher -->
<script id="table-filter-switcher-template" type="text/x-handlebars-template">
	<div class="pls_switcher-group pill">
		{{#each field.options}}
			<label class="pls_switcher">
				<input type="radio" name="filter[{{../field.name}}]" value="{{@key}}" {{#ifEquals ../field.selected @key}} checked {{/ifEquals}}><div>{{this}}</div>
			</label>
		{{/each}}
	</div>
</script>


<!-- Table filter - range -->
<script id="table-filter-range-template" type="text/x-handlebars-template">
	<div class="pls_row-8 inline {{#ifEquals field.type 'date'}} pls_daterange {{/ifEquals}}">
    	<div class="pls_column-50">
            <div class="pls_field">
                <input type="text" name="filter[from-{{field.name}}]" class="pls_input" placeholder="{{field.range_title.from}}" value="{{field.value}}">
            </div>
    	</div>

    	<div class="pls_column-50">
            <div class="pls_field">
                <input type="text" name="filter[to-{{field.name}}]" class="pls_input" placeholder="{{field.range_title.to}}" value="{{field.value}}">
            </div>
    	</div>
    </div>
</script>