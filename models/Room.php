<?php
/**
 * Room Model
 * Handles all room-related database operations
 */

class Room extends Model {
    protected static $table = 'rooms';
    
    public static function getActive() {
        return static::db()->select(
            "SELECT * FROM `rooms` WHERE `status` = 1 AND `removed` = 0 ORDER BY `id` DESC",
            [], ''
        );
    }
    
    public static function getActiveLimit($limit = 3) {
        return static::db()->select(
            "SELECT * FROM `rooms` WHERE `status` = ? AND `removed` = ? ORDER BY `id` DESC LIMIT ?",
            [1, 0, $limit],
            'iii'
        );
    }
    
    public static function search($adults, $children) {
        return static::db()->select(
            "SELECT * FROM `rooms` WHERE `adult` >= ? AND `children` >= ? AND `status` = 1 AND `removed` = 0",
            [$adults, $children],
            'ii'
        );
    }
    
    public static function getWithDetails($id) {
        $room = static::find($id);
        if (!$room) return null;
        
        $room['features']   = static::getFeatures($id);
        $room['facilities'] = static::getFacilities($id);
        $room['images']     = static::getImages($id);
        $room['thumbnail']  = static::getThumbnail($id);
        $room['rating']     = static::getAverageRating($id);
        
        return $room;
    }
    
    public static function getFeatures($roomId) {
        $result = static::db()->select(
            "SELECT f.id, f.name FROM `features` f
             INNER JOIN `room_features` rf ON f.id = rf.features_id
             WHERE rf.room_id = ?",
            [$roomId], 'i'
        );
        return static::fetchAll($result);
    }
    
    public static function getFacilities($roomId) {
        $result = static::db()->select(
            "SELECT f.id, f.name, f.icon FROM `facilities` f
             INNER JOIN `room_facilities` rf ON f.id = rf.facilities_id
             WHERE rf.room_id = ?",
            [$roomId], 'i'
        );
        return static::fetchAll($result);
    }
    
    public static function getImages($roomId) {
        $result = static::db()->select(
            "SELECT * FROM `room_images` WHERE `room_id` = ?",
            [$roomId], 'i'
        );
        return static::fetchAll($result);
    }
    
    public static function getThumbnail($roomId) {
        $result = static::db()->select(
            "SELECT `image` FROM `room_images` WHERE `room_id` = ? AND `thumb` = 1 LIMIT 1",
            [$roomId], 'i'
        );
        $row = static::fetchOne($result);
        return $row ? ROOMS_IMG_PATH . $row['image'] : ROOMS_IMG_PATH . 'thumbnail.jpg';
    }
    
    public static function getAverageRating($roomId) {
        $result = static::db()->select(
            "SELECT AVG(rating) AS avg_rating FROM `rating_review` WHERE `room_id` = ?",
            [$roomId], 'i'
        );
        $row = static::fetchOne($result);
        return $row ? round((float)$row['avg_rating'], 1) : 0;
    }
    
    public static function getReviews($roomId) {
        $result = static::db()->select(
            "SELECT rr.*, uc.name AS user_name
             FROM `rating_review` rr
             INNER JOIN `user_cred` uc ON rr.user_id = uc.id
             WHERE rr.room_id = ?
             ORDER BY rr.sr_no DESC",
            [$roomId], 'i'
        );
        return static::fetchAll($result);
    }
    
    public static function checkAvailability($roomId, $checkIn, $checkOut) {
        $room = static::find($roomId);
        if (!$room) return false;
        
        $result = static::db()->select(
            "SELECT COUNT(*) AS booked FROM `booking_order`
             WHERE `booking_status` = 'booked' AND `room_id` = ?
             AND `check_out` > ? AND `check_in` < ?",
            [$roomId, $checkIn, $checkOut],
            'iss'
        );
        $row = static::fetchOne($result);
        $booked = (int)($row['booked'] ?? 0);
        
        return ($room['quantity'] - $booked) > 0;
    }
    
    // Bulk queries for performance (N+1 fix)
    public static function bulkGetFeatures(array $ids) {
        if (empty($ids)) return [];
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $types = str_repeat('i', count($ids));
        
        $result = static::db()->select(
            "SELECT rf.room_id, f.id, f.name FROM `features` f
             INNER JOIN `room_features` rf ON f.id = rf.features_id
             WHERE rf.room_id IN ($placeholders)",
            $ids, $types
        );
        
        $map = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $map[$row['room_id']][] = ['id' => $row['id'], 'name' => $row['name']];
        }
        return $map;
    }
    
    public static function bulkGetFacilities(array $ids) {
        if (empty($ids)) return [];
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $types = str_repeat('i', count($ids));
        
        $result = static::db()->select(
            "SELECT rf.room_id, f.id, f.name FROM `facilities` f
             INNER JOIN `room_facilities` rf ON f.id = rf.facilities_id
             WHERE rf.room_id IN ($placeholders)",
            $ids, $types
        );
        
        $map = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $map[$row['room_id']][] = $row;
        }
        return $map;
    }
    
    public static function bulkGetThumbnails(array $ids) {
        if (empty($ids)) return [];
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $types = str_repeat('i', count($ids));
        
        $result = static::db()->select(
            "SELECT `room_id`, `image` FROM `room_images`
             WHERE `room_id` IN ($placeholders) AND `thumb` = 1",
            $ids, $types
        );
        
        $map = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $map[$row['room_id']] = ROOMS_IMG_PATH . $row['image'];
        }
        return $map;
    }
    
    public static function bulkGetRatings(array $ids) {
        if (empty($ids)) return [];
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $types = str_repeat('i', count($ids));
        
        $result = static::db()->select(
            "SELECT `room_id`, AVG(rating) AS avg_rating
             FROM `rating_review`
             WHERE `room_id` IN ($placeholders)
             GROUP BY `room_id`",
            $ids, $types
        );
        
        $map = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $map[$row['room_id']] = round((float)$row['avg_rating'], 1);
        }
        return $map;
    }
    
    public static function bulkGetAvailability(array $ids, $checkIn, $checkOut) {
        if (empty($ids)) return [];
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $types = str_repeat('i', count($ids));
        
        $result = static::db()->select(
            "SELECT `room_id`, COUNT(*) AS booked FROM `booking_order`
             WHERE `booking_status` = 'booked' AND `room_id` IN ($placeholders)
             AND `check_out` > ? AND `check_in` < ?
             GROUP BY `room_id`",
            array_merge($ids, [$checkIn, $checkOut]),
            $types . 'ss'
        );
        
        $map = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $map[$row['room_id']] = (int)$row['booked'];
        }
        return $map;
    }
    
    public static function getMaxGuests() {
        $result = static::db()->select(
            "SELECT MAX(adult) AS max_adult, MAX(children) AS max_children
             FROM `rooms` WHERE `status` = 1 AND `removed` = 0"
        );
        return static::fetchOne($result);
    }
    
    public static function syncFeatures($roomId, array $featureIds) {
        static::db()->delete("DELETE FROM `room_features` WHERE `room_id` = ?", [$roomId], 'i');
        
        if (empty($featureIds)) return true;
        
        $conn = static::db()->getConnection();
        $stmt = mysqli_prepare($conn, "INSERT INTO `room_features`(`room_id`, `features_id`) VALUES (?,?)");
        foreach ($featureIds as $fid) {
            mysqli_stmt_bind_param($stmt, 'ii', $roomId, $fid);
            mysqli_stmt_execute($stmt);
        }
        mysqli_stmt_close($stmt);
        return true;
    }
    
    public static function syncFacilities($roomId, array $facilityIds) {
        static::db()->delete("DELETE FROM `room_facilities` WHERE `room_id` = ?", [$roomId], 'i');
        
        if (empty($facilityIds)) return true;
        
        $conn = static::db()->getConnection();
        $stmt = mysqli_prepare($conn, "INSERT INTO `room_facilities`(`room_id`, `facilities_id`) VALUES (?,?)");
        foreach ($facilityIds as $fid) {
            mysqli_stmt_bind_param($stmt, 'ii', $roomId, $fid);
            mysqli_stmt_execute($stmt);
        }
        mysqli_stmt_close($stmt);
        return true;
    }
    
    public static function softDelete($roomId) {
        return static::db()->update(
            "UPDATE `rooms` SET `removed` = 1 WHERE `id` = ?",
            [$roomId], 'i'
        );
    }
    
    public static function toggleStatus($roomId, $status) {
        return static::db()->update(
            "UPDATE `rooms` SET `status` = ? WHERE `id` = ?",
            [$status, $roomId], 'ii'
        );
    }
}
