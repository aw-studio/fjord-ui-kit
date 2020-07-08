# Fjord Ui Kit

A package with helpful Blade components for your
[fjord](https://github.com/aw-studio/fjord) project.

## Setup

Publish the necessary assets.

```shell
php artisan vendor:publish --provider="BladeScript\ServiceProvider"
php artisan vendor:publish --provider="BladeStyle\ServiceProvider"
```

To include all styles and scripts the `x-styles` tag must be placed in the head
and the `x-scripts` tag at the end of the body.

```html
<!DOCTYPE html>
<html lang="en">
	<head>
		...

		<x-styles />
	</head>
	<body>
		...

		<x-scripts />
	</body>
</html>
```

## Customize

If you want to customize the blade components, you can simply publish them and
edit them as desired.

```shell
php artisan vendor:publish --provider="Fjord\Ui\FjordUiServiceProvider" --tag=views
```

## Image

The image component uses lazy loading and prints a base64 string of the image
before loading it. It also outputs the appropriate media conversion for the
corresponding screen sizes.

The component requires an image parameter with a media model:

```php
<x-fj-image :image="$model->image"/>
```

## Helpers

### `child_is_active`

The child is active determines wether a list item has a child with an active
route. The following example will add the `is-active` class when a list item has
an active `route` that is added from route field.

```php
$form->route('route_field')->collection('app')->title('Pick a route.');
```

```php
@foreach($data->list as $item)
	<span class="child_is_active($item, 'route_field', 'is-active')">
		{{ $item->title }}
	</span>
@endforeach
```
