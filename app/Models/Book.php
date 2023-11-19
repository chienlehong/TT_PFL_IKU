<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\Input;

class Book extends Model
{
    use HasFactory;
    protected $table = 'books';
    static $limit = 12;
    protected $fillabel = [
        'book_name',
        'description',
        'publish_date',
        'suggest',
        'author_id',
        'company_id',
        'category_id',
        'publishing_house',
        'translator',
        'number_of_pages',
        'quality',
        'price',
        'cover_price',
        'book_image',
        'images'
    ];
    public function author()
    {
        return $this->belongsTo(Author::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function comment(){
        return $this->hasMany(Comment::class);
    }
    public function oderdetail(){
        return $this->hasMany(OrderDetail::class);
    }

    public function saves(){
        return $this->hasMany(Save::class);
    }
    public static function getAllBookByCategoryId($categories = array())
    {
        $page = request()->input::get('page', 1);
        $offset = ($page - 1) * self::$limit;
        $str = implode(',', $categories);
        return DB::select("SELECT DISTINCT  b.id as bookId,
                            count(comments.id) as 'totalComment',
                            b.book_name,
                            b.book_image,
                            b.quality,
                            b.price,
                            a.author_name,
                            a.id as authorId,
                            b.cover_price
                    FROM books as b
                    LEFT OUTER JOIN comments  as comments
                    ON b.id=comments.book_id
                    LEFT OUTER JOIN authors  as a
                    ON a.id=b.author_id
                    WHERE b.category_id IN ($str)
                    GROUP BY b.id,b.book_name,
                            b.book_image,
                            b.quality,
                            b.price,
                            a.author_name,
                            a.id,
                            b.cover_price
                    ORDER BY b.suggest DESC
                    LIMIT $offset, 12
                ");
    }

    public static function getAllBookSuggestByCategoryId($categories = array())
    {
        $str = implode(',', $categories);
        return DB::select(
            "SELECT b.id as bookId,
                            count(comments.id) as 'totalComment',
                            b.book_name,
                            b.book_image,
                            b.quality,
                            b.price,
                            a.author_name,
                            a.id as authorId,
                            b.cover_price,
                            b.publish_date
                    FROM books as b
                    LEFT OUTER JOIN comments  as comments
                    ON b.id=comments.book_id
                    LEFT OUTER JOIN authors  as a
                    ON a.id=b.author_id
                    WHERE b.category_id IN ($str)
                    GROUP BY b.id,b.book_name,
                            b.book_image,
                            b.quality,
                            b.price,
                            a.author_name,
                            a.id,
                            b.cover_price,
                            b.publish_date
                    ORDER BY b.suggest,b.publish_date DESC
                    LIMIT 12
                "
        );
    }

    public static function getAllBookHotByCategoryId($categories = array())
    {
        $str = implode(',', $categories);
        return  DB::select(
            "SELECT b.id as bookId,
                            count(comments.id) as 'totalComment',
                            sum(od.quality) as totalqty,
                            b.book_name,
                            b.book_image,
                            b.quality,
                            b.price,
                            a.author_name,
                            a.id as authorId,
                            b.cover_price
                    FROM books as b
                    LEFT OUTER JOIN comments  as comments
                    ON b.id=comments.book_id
                    LEFT OUTER JOIN authors  as a
                    ON a.id=b.author_id
                    JOIN order_details  as od
                    ON b.id=od.book_id
                    JOIN orders  as o
                    ON o.id=od.order_id
                    WHERE b.category_id IN ($str)
                    GROUP BY b.id,b.book_name,
                            b.book_image,
                            b.quality,
                            b.price,
                            a.author_name,
                            a.id,
                            b.cover_price
                    ORDER BY totalqty DESC
                    LIMIT 12
                "
        );
    }

    public static function getAllBookHotWeek()
    {
        $page = request()->input::get('page', 1);
        $offset = ($page - 1) * self::$limit;
        return  DB::select(
            "SELECT b.id as bookId,
                            count(comments.id) as 'totalComment',
                            sum(od.quality) as totalqty,
                            b.book_name,
                            b.book_image,
                            b.quality,
                            b.price,
                            a.author_name,
                            a.id as authorId,
                            b.cover_price
                    FROM books as b
                    LEFT OUTER JOIN comments  as comments
                    ON b.id=comments.book_id
                    LEFT OUTER JOIN authors  as a
                    ON a.id=b.author_id
                    JOIN order_details  as od
                    ON b.id=od.book_id
                    JOIN orders  as o
                    ON o.id=od.order_id
                    where o.created_at between adddate(now(),-7) and now()
                    GROUP BY b.id,b.book_name,
                            b.book_image,
                            b.quality,
                            b.price,
                            a.author_name,
                            a.id,
                            b.cover_price
                    ORDER BY totalqty DESC
                    LIMIT $offset, 12
                "
        );
    }

    public static function getAllBookHotMonth()
    {
        $page = request()->input::get('page', 1);
        $offset = ($page - 1) * self::$limit;
        return  DB::select(
            "SELECT b.id as bookId,
                            count(comments.id) as 'totalComment',
                            sum(od.quality) as totalqty,
                            b.book_name,
                            b.book_image,
                            b.quality,
                            b.price,
                            a.author_name,
                            a.id as authorId,
                            b.cover_price
                    FROM books as b
                    LEFT OUTER JOIN comments  as comments
                    ON b.id=comments.book_id
                    LEFT OUTER JOIN authors  as a
                    ON a.id=b.author_id
                    JOIN order_details  as od
                    ON b.id=od.book_id
                    JOIN orders  as o
                    ON o.id=od.order_id
                    where o.created_at between adddate(now(),-30) and now()
                    GROUP BY b.id,b.book_name,
                            b.book_image,
                            b.quality,
                            b.price,
                            a.author_name,
                            a.id,
                            b.cover_price
                    ORDER BY totalqty DESC
                    LIMIT $offset, 12
                "
        );
    }

    public static function getTotalBookHotMonth()
    {
        return  count(DB::select(
            "SELECT b.id
                    FROM books as b
                    JOIN order_details  as od
                    ON b.id=od.book_id
                    JOIN orders  as o
                    ON o.id=od.order_id
                    where o.created_at between adddate(now(),-30) and now()
                "
        ));
    }

    public static function getTotalBookHotWeek()
    {
        return  count(DB::select(
            "SELECT b.id
                    FROM books as b
                    JOIN order_details  as od
                    ON b.id=od.book_id
                    JOIN orders  as o
                    ON o.id=od.order_id
                    where o.created_at between adddate(now(),-7) and now()
                "
        ));
    }

    public static function getAllBookNewPublish()
    {
        $page = request()->input::get('page', 1);
        $offset = ($page - 1) * self::$limit;
        return  DB::select(
            "SELECT b.id as bookId,
                            count(comments.id) as 'totalComment',
                            b.book_name,
                            b.book_image,
                            b.quality,
                            b.price,
                            a.author_name,
                            a.id as authorId,
                            b.cover_price
                    FROM books as b
                    LEFT OUTER JOIN comments  as comments
                    ON b.id=comments.book_id
                    LEFT OUTER JOIN authors  as a
                    ON a.id=b.author_id
                    GROUP BY b.id,b.book_name,
                            b.book_image,
                            b.quality,
                            b.price,
                            a.author_name,
                            a.id,
                            b.cover_price
                    ORDER BY b.publish_date DESC
                    LIMIT $offset, 12
                "
        );
    }

    public static function getAllBookNewByCategoryId($categories = array())
    {
        $str = implode(',', $categories);
        return  DB::select(
            "SELECT b.id as bookId,
                            count(comments.id) as 'totalComment',
                            b.book_name,
                            b.book_image,
                            b.quality,
                            b.price,
                            a.author_name,
                            a.id as authorId,
                            b.cover_price
                    FROM books as b
                    LEFT OUTER JOIN comments  as comments
                    ON b.id=comments.book_id
                    LEFT OUTER JOIN authors  as a
                    ON a.id=b.author_id
                    WHERE b.category_id IN ($str)
                    GROUP BY b.id,b.book_name,
                            b.book_image,
                            b.quality,
                            b.price,
                            a.author_name,
                            a.id,
                            b.cover_price
                    ORDER BY b.publish_date DESC
                    LIMIT 12
                "
        );
    }

    public static function getAllBookByAuthorId($authorId = 1)
    {
        $page = request()->input::get('page', 1);
        $offset = ($page - 1) * self::$limit;
        return  DB::select(
            "SELECT b.id as bookId,
                                    count(comments.id) as 'totalComment',
                                    b.book_name,
                                    b.book_image,
                                    b.quality,
                                    b.price,
                                    a.author_name,
                                    a.id as authorId,
                                    c.company_name,
                                    c.id as companyId,
                                    b.cover_price
                            FROM books as b
                            LEFT OUTER JOIN comments  as comments
                            ON b.id=comments.book_id
                            LEFT OUTER JOIN authors  as a
                            ON a.id=b.author_id
                            LEFT OUTER JOIN companies  as c
                            ON c.id=b.company_id
                            WHERE b.author_id = $authorId
                            GROUP BY b.id,b.book_name,
                                    b.book_image,
                                    b.quality,
                                    b.price,
                                    a.author_name,
                                    a.id,
                                    c.company_name,
                                    c.id,
                                    b.cover_price
                        LIMIT $offset, 12
                        "
        );
    }

    public static function getTotalBookByAuthorId($authorId = 1)
    {
        return  count(DB::select(
            "SELECT b.id
                            FROM books as b
                            LEFT OUTER JOIN authors  as a
                            ON a.id=b.author_id
                            WHERE b.author_id = $authorId
                        "
        ));
    }

    public static function getAllBookByCompanyId($companyId = 1)
    {
        $page = request()->input::get('page', 1);
        $offset = ($page - 1) * self::$limit;
        return  DB::select(
            "SELECT b.id as bookId,
                                    count(comments.id) as 'totalComment',
                                    b.book_name,
                                    b.book_image,
                                    b.quality,
                                    b.price,
                                    a.author_name,
                                    a.id as authorId,
                                    b.cover_price
                            FROM books as b
                            LEFT OUTER JOIN comments  as comments
                            ON b.id=comments.book_id
                            LEFT OUTER JOIN authors  as a
                            ON a.id=b.author_id
                            LEFT OUTER JOIN companies  as c
                            ON b.company_id=c.id
                            WHERE b.company_id = $companyId
                            GROUP BY b.id,b.book_name,
                                    b.book_image,
                                    b.quality,
                                    b.price,
                                    a.author_name,
                                    a.id,
                                    b.cover_price
                            LIMIT $offset, 12
                        "
        );
    }

    public static function getTotalBookByCompanyId($companyId = 1)
    {
        return  count(DB::select(
            "SELECT b.id
                            FROM books as b
                            LEFT OUTER JOIN companies  as c
                            ON b.company_id=c.id
                            WHERE b.company_id = $companyId
                        "
        ));
    }

    public static function getAllBookByKeySearch($search = '')
    {
        $page = request()->input::get('page', 1);
        $offset = ($page - 1) * self::$limit;
        return  DB::select(
            "SELECT b.id as bookId,
                                    count(comments.id) as 'totalComment',
                                    b.book_name,
                                    b.book_image,
                                    b.quality,
                                    b.price,
                                    a.author_name,
                                    a.id as authorId,
                                    b.cover_price
                            FROM books as b
                            LEFT OUTER JOIN comments  as comments
                            ON b.id=comments.book_id
                            LEFT OUTER JOIN authors  as a
                            ON a.id=b.author_id
                            LEFT OUTER JOIN companies  as c
                            ON b.company_id=c.id
                            WHERE b.book_name LIKE '%$search%' OR a.author_name LIKE '%$search%' OR c.company_name LIKE '%$search%'
                            GROUP BY b.id,b.book_name,
                                    b.book_image,
                                    b.quality,
                                    b.price,
                                    a.author_name,
                                    a.id,
                                    b.cover_price

                            LIMIT $offset, 12
                        "
        );
    }

    public static function getTotalBookByKeySearch($search = '')
    {
        return  count(DB::select(
            "SELECT b.id
                            FROM books as b
                            LEFT OUTER JOIN authors  as a
                            ON a.id=b.author_id
                            LEFT OUTER JOIN companies  as c
                            ON b.company_id=c.id
                            WHERE b.book_name LIKE '%$search%' OR a.author_name LIKE '%$search%' OR c.company_name LIKE '%$search%'
                        "
        ));
    }

    public static function getBookByBookId($bookID = 0)
    {
        return  DB::selectOne(
            "SELECT b.id as bookId,
                                    count(comments.id) as 'totalComment',
                                    avg(comments.rate) as 'avgComment',
                                    b.book_name,
                                    b.book_image,
                                    b.description,
                                    b.quality,
                                    b.category_id,
                                    b.price,
                                    b.cover_price,
                                    b.number_of_pages,
                                    b.translator,
                                    b.publish_date,
                                    b.publishing_house,
                                    b.images,
                                    a.id as authorId,
                                    a.author_name,
                                    a.author_info,
                                    a.author_image,
                                    a.author_name,
                                    com.company_image,
                                    com.company_name,
                                    com.id as companyId
                            FROM books as b
                            LEFT OUTER JOIN categories  as c
                            ON c.id = b.category_id
                            LEFT OUTER JOIN companies  as com
                            ON b.company_id=com.id
                            LEFT OUTER JOIN comments  as comments
                            ON b.id=comments.book_id
                            LEFT OUTER JOIN authors  as a
                            ON a.id=b.author_id
                            WHERE b.id = $bookID
                            GROUP BY b.id,b.book_name,
                                    b.book_image,
                                    b.description,
                                    b.quality,
                                    b.category_id,
                                    b.price,
                                    b.cover_price,
                                    b.number_of_pages,
                                    b.translator,
                                    b.publish_date,
                                    b.publishing_house,
                                    b.images,
                                    authorId,
                                    a.author_info,
                                    a.author_image,
                                    a.author_name,
                                    com.company_image,
                                    com.company_name,
                                    companyId

                        "
        );
    }

    public static function getAllBookByOrderId($orderId = 1)
    {
        return  DB::select(
            "SELECT b.id as bookId,
                            sum(od.quality) as totalqty,
                            b.book_name,
                            od.price
                            FROM books as b
                            LEFT OUTER JOIN comments  as comments
                            ON b.id=comments.book_id
                            LEFT OUTER JOIN authors  as a
                            ON a.id=b.author_id
                            JOIN order_details  as od
                            ON b.id=od.book_id
                            JOIN orders  as o
                            ON o.id=od.order_id
                            where od.book_id=b.id and o.id=$orderId

                            GROUP BY b.id,
                                    b.book_name,
                                    od.price
                            ORDER BY totalqty DESC
                "
        );
    }

    public static function getBookInCart($bookID = 0)
    {
        return  Book::where('books.id', '=', $bookID)
            ->select(
                'books.id as bookId',
                'books.book_image',
                'books.quality',
                'books.cover_price',
                'com.company_name',
                'com.id as companyId'
            )
            ->leftJoin('companies as com', 'books.company_id', '=', 'com.id')
            ->get()->first();
    }
}
