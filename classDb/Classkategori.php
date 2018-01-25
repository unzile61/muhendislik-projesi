<?php 
	class Classkategori{

		public function create($kategori_adi){
			include 'baglan.php';
			$sql = "INSERT INTO tbl_kategori (kategori_adi) VALUES (?)";
			$stmt = $conn->prepare($sql);
			$stmt->bind_param('s',$kategori_adi);
			$query = $stmt->execute();
			$stmt->close();
			$conn->close();
			return $query;
		}
		public function readbyid($id){
			include 'baglan.php';
			$sql = "SELECT * FROM tbl_kategori WHERE id = '".$id."'";
			$query = $conn->query($sql);
			$conn->close();
			return $query;
		}
		public function readAll(){
			include 'baglan.php';
			$sql = "SELECT * FROM tbl_kategori";
			$query = $conn->query($sql);
			$conn->close();
			return $query;
		}
		public function updatebyid($id,$kategori_adi){
			include 'baglan.php';
			$sql = "UPDATE tbl_kategori SET kategori_adi = ? WHERE id = ?";
			$stmt = $conn->prepare($sql);
			$stmt->bind_param('si',$kategori_adi,$id);
			$query = $stmt->execute();
			$stmt->close();
			$conn->close();
			return $query;
		}
		public function deletebyid($id){
			include 'baglan.php';
			$sql = "DELETE FROM tbl_kategori WHERE id = ?";
			$stmt = $conn->prepare($sql);
			$stmt->bind_param('i',$id);
			$query = $stmt->execute();
			$stmt->close();
			$conn->close();
			return $query;
		}
	}
 ?>