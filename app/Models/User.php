<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'usucod',
        'name',
        'email',
        'password',
        'usuclicod',
        'usucencod',
        'usutarcod',
        'usuofecod',
        'usudes1',
        'usunuevo',
        'usuivacod',
        'accesorapido',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'usugrucod'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function articulos()
    {
        return $this->belongsToMany(Articulo::class, 'qanet_clientearticulo', 'artcod', 'clicod', 'usuclicod', 'artcod');
    }

    public function categorias()
    {
        return $this->belongsToMany(Category::class, 'qanet_clientecategoria', 'clicod', 'catcod', 'usuclicod', 'id');
    }

    // public function categorias()
    // {
    //     return $this->hasManyThrough(Category::class, ClienteCategoria::class, 'clicod',  'catcod', 'usuclicod', 'catcod');
    // }

    public function accessibleArticles()
    {
        $categoryArticleIds = Articulo::whereIn('artcatcodw1', $this->categorias()->pluck('cat_categorias.id'))->pluck('artcod');

        // dd($categoryArticleIds);
        $directArticleIds = $this->articulos()->pluck('qanet_articulo.artcod');

        $allArticleIds = $categoryArticleIds->merge($directArticleIds)->unique();

        $articles = Articulo::whereIn('artcod', $allArticleIds);


        return $articles;
    }

    public function historico()
    {
        return $this->hasMany(Historico::class, 'estclicod', 'usuclicod');
    }


    public function documentos()
    {
        return $this->hasMany(Documento::class, 'docclicod', 'usuclicod');
    }

    public function ofertas()
    {
        return $this->hasMany(OfertaC::class, 'ofccod', 'usuofecod');
    }

    public function favoritos()
    {
        return $this->hasMany(Favorito::class, 'favusucod', 'id');
    }

    public function direcciones()
    {
        return $this->hasMany(ClienteDireccion::class, 'dirclicod', 'usuclicod')
            ->join('users', function ($join) {
                $join->on('clientes_direcciones.dirclicod', '=', 'users.usuclicod')
                    ->on('clientes_direcciones.dircencod', '=', 'users.usucencod');
            })
            ->select('clientes_direcciones.*'); // Ajustar según sea necesario
    }
}
