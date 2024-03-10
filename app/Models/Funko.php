<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;



class Funko extends Model


{   
    public static string $IMAGE_DEFAULT = 'https://via.placeholder.com/150';

    protected $table = 'funkos';


    /**
     * Estos se pueden asignar en masa con el método create() o update().
     *
     * @var array<int, string>
     */
    protected $fillable = [ 

        'modelo', 

        'descripcion',

        'imagen', 

        'precio', 

        'stock', 

        'categoria_id', 

        'isDeleted', 

    ]; 

    
    /**
     * Esto se oculta cuando se serializa el modelo.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'isDeleted',
    ];

     /**
     * Esto se convierte automáticamente en tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'isDeleted' => 'boolean',
    ];

    /**
     * Genera un nuevo UUID y lo asigna al atributo uuid del modelo.
     * 
     */

    protected static function boot() 

    { 

        parent::boot(); 
  


        static::creating(function ($producto) { 

            $producto->uuid = Str::uuid(); 
        }); 

    } 

    
        // Busca productos donde el modelo o la marca coincidan con el término de búsqueda, ignorando mayúsculas/minúsculas 

    public function scopeSearch($query, $search) 

    { 
        return $query->whereRaw('LOWER(modelo) LIKE ?', ["%" . strtolower($search) . "%"]) ; 

    } 

    /**
     * Obtiene la categoría a la que pertenece el funko.
     */
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
    
}
