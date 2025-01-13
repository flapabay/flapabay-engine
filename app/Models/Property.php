<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    /** @use HasFactory<\Database\Factories\PropertyFactory> */
    use HasFactory;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'location',
        'address',
        'county',
        'latitude',
        'longitude',
        'check_in_hour',
        'check_out_hour',
        'num_of_guests',
        'num_of_children',
        'maximum_guests',
        'allow_extra_guests',
        'neighborhood_area',
        'country',
        'show_contact_form_instead_of_booking',
        'allow_instant_booking',
        'currency',
        'price_range',
        'price',
        'price_per_night',
        'additional_guest_price',
        'children_price',
        'amenities',
        'house_rules',
        'page',
        'rating',
        'favorite',
        'images',
        'video_link',
        'verified',
        'property_type',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    public static function createProperty($data)
    {

        return Property::create([
            'title' => $data['title'], // Property title
            'description' => $data['description'], // Property description
            'location' => $data['location'], // Location of the property
            'address' => $data['address'], // Address of the property
            'county' => $data['county'], // County
            'latitude' => $data['latitude'], // Latitude
            'longitude' => $data['longitude'], // Longitude
            'check_in_hour' => $data['check_in_hour'], // Check-in hour
            'check_out_hour' => $data['check_out_hour'], // Check-out hour
            'num_of_guests' => $data['num_of_guests'], // Number of guests
            'num_of_children' => $data['num_of_children'], // Number of children
            'maximum_guests' => $data['maximum_guests'], // Maximum guests allowed
            'country' => $data['country'], // Country
            'currency' => $data['currency'], // Currency
            'price_range' => $data['price_range'], // Price range
            'price' => $data['price'], // Price
            'additional_guest_price' => $data['additional_guest_price'], // Additional guest price
            'children_price' => $data['children_price'], // Children's price
            'amenities' => $data['amenities'], // Amenities (should be a JSON string or comma-separated values)
            'house_rules' => $data['house_rules'], // House rules (if any)
            'rating' => $data['rating'], // Rating
            'favorite' => $data['favorite'], // Favorite flag (1/0)
            'video_link' => $data['video_link'], // Video link (if any)
            'verified' => $data['verified'], // Verification status (1/0)
        ]);
    }


    /**
     * Scope a query to only include verified properties.
     */
    public function scopeVerified($query)
    {
        return $query->where('verified', true);
    }

    /**
     * Scope a query to only include favorite properties.
     */
    public function scopeFavorite($query)
    {
        return $query->where('favorite', true);
    }

    /**
     * Scope a query to filter by property type.
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('property_type', $type);
    }

    /**
     * Scope a query to filter properties within a price range.
     */
    public function scopeWithinPriceRange($query, $min, $max)
    {
        return $query->whereBetween('price', [$min, $max]);
    }

    /**
     * Relationship with Post model (if needed).
     */
    public function listing()
    {
        // return $this->hasMany(Listing::class, 'property_id');
    }

    /**
     * Get the formatted price range.
     */
    public function getFormattedPriceRangeAttribute()
    {
        if ($this->price_range) {
            return 'Min: ' . $this->price_range['min'] . ' - Max: ' . $this->price_range['max'];
        }
        return null;
    }

    /**
     * Get the full address as a formatted string.
     */
    public function getFullAddressAttribute()
    {
        return $this->address . ', ' . $this->county . ', ' . $this->country;
    }

    /**
     * Determine if the property allows instant booking.
     */
    public function allowsInstantBooking()
    {
        return $this->allow_instant_booking;
    }

    /**
     * Check if a property is marked as a favorite.
     */
    public function isFavorite()
    {
        return $this->favorite;
    }

    /**
     * Get the URL for the first image (if images are an array).
     */
    public function getFirstImageUrlAttribute()
    {
        return $this->images && count($this->images) > 0 ? $this->images[0] : null;
    }

    /**
     * Get the Google Maps URL for the property location.
     */
    public function getGoogleMapsUrlAttribute()
    {
        if ($this->latitude && $this->longitude) {
            return "https://www.google.com/maps?q={$this->latitude},{$this->longitude}";
        }
        return null;
    }
}
