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
        'usunuevo',
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
        // dd($this->belongsToMany(Category::class, 'qanet_clientecategoria', 'catcod', 'clicod', 'usuclicod', 'id'));
        return $this->belongsToMany(Category::class, 'qanet_clientecategoria', 'clicod', 'catcod', 'usuclicod', 'id');

    }

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
}
