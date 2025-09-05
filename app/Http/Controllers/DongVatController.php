<?php

namespace App\Http\Controllers;

use App\Services\DongVatService;
use App\Services\BacChiService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DongVatController extends Controller
{
    protected $dongVatService;
    protected $bacChiService;

    public function __construct(DongVatService $dongVatService, BacChiService $bacChiService)
    {
        $this->dongVatService = $dongVatService;
        $this->bacChiService = $bacChiService;
    }

    public function index(): View
    {
        $dongVats = $this->dongVatService->getAll();
        $statistics = $this->dongVatService->getStatistics();

        return view('pages.dong-vat.index', compact('dongVats', 'statistics'));
    }

    public function create(): View
    {
        $bacChis = $this->bacChiService->getAll();

        return view('pages.dong-vat.create', compact('bacChis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bac_chi_id' => 'required|exists:bac_chi,id',
            'ten_khoa_hoc' => 'required|string|max:255',
            'ten_tieng_viet' => 'required|string|max:255',
            'ten_tac_gia' => 'nullable|string|max:255',
            'hinh_thai' => 'nullable|string',
            'sinh_thai' => 'nullable|string',
            'dac_huu' => 'nullable|string|max:50',
            'gia_tri' => 'nullable|string',
            'sach_do' => 'nullable|string|max:50',
            'iucn' => 'nullable|string|max:50',
            'nd_84' => 'nullable|string|max:50',
            'nguon' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120'
        ], [
            'bac_chi_id.required' => 'Chi không được để trống',
            'bac_chi_id.exists' => 'Chi không tồn tại',
            'ten_khoa_hoc.required' => 'Tên khoa học không được để trống',
            'ten_khoa_hoc.max' => 'Tên khoa học không được vượt quá 255 ký tự',
            'ten_tieng_viet.required' => 'Tên tiếng Việt không được để trống',
            'ten_tieng_viet.max' => 'Tên tiếng Việt không được vượt quá 255 ký tự',
            'ten_tac_gia.max' => 'Tên tác giả không được vượt quá 255 ký tự',
            'dac_huu.max' => 'Đặc hữu không được vượt quá 50 ký tự',
            'sach_do.max' => 'Sách đỏ không được vượt quá 50 ký tự',
            'iucn.max' => 'IUCN không được vượt quá 50 ký tự',
            'nd_84.max' => 'NĐ 84 không được vượt quá 50 ký tự',
            'images.*.image' => 'File phải là hình ảnh',
            'images.*.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif, webp',
            'images.*.max' => 'Kích thước hình ảnh không được vượt quá 5MB'
        ]);

        try {
            $dongVat = $this->dongVatService->create($request->all());

            // Xử lý upload ảnh nếu có
            if ($request->hasFile('images')) {
                $result = $this->dongVatService->addMultipleImages($dongVat->id, $request->file('images'));
                if (!$result['success']) {
                    // Nếu upload ảnh thất bại, xóa động vật đã tạo
                    $dongVat->delete();
                    throw new \Exception($result['error']);
                }
            }

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Thêm động vật thành công!',
                    'redirect' => route('dong-vat.index')
                ]);
            }

            return redirect()->route('dong-vat.index')
                ->with('success', 'Thêm động vật thành công!');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 400);
            }

            return redirect()->back()->withInput()->with('err', $e->getMessage());
        }
    }

    public function show(int $id): View
    {
        $dongVat = $this->dongVatService->findById($id);

        if (!$dongVat) {
            abort(404, 'Động vật không tồn tại');
        }

        return view('pages.dong-vat.show', compact('dongVat'));
    }

    public function edit(int $id): View
    {
        $dongVat = $this->dongVatService->findById($id);
        $bacChis = $this->bacChiService->getAll();

        if (!$dongVat) {
            abort(404, 'Động vật không tồn tại');
        }

        // Load ảnh hiện có
        $images = $this->dongVatService->getImages($id);

        return view('pages.dong-vat.edit', compact('dongVat', 'bacChis', 'images'));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'bac_chi_id' => 'required|exists:bac_chi,id',
            'ten_khoa_hoc' => 'required|string|max:255',
            'ten_tieng_viet' => 'required|string|max:255',
            'ten_tac_gia' => 'nullable|string|max:255',
            'hinh_thai' => 'nullable|string',
            'sinh_thai' => 'nullable|string',
            'dac_huu' => 'nullable|string|max:50',
            'gia_tri' => 'nullable|string',
            'sach_do' => 'nullable|string|max:50',
            'iucn' => 'nullable|string|max:50',
            'nd_84' => 'nullable|string|max:50',
            'nguon' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120'
        ], [
            'bac_chi_id.required' => 'Chi không được để trống',
            'bac_chi_id.exists' => 'Chi không tồn tại',
            'ten_khoa_hoc.required' => 'Tên khoa học không được để trống',
            'ten_khoa_hoc.max' => 'Tên khoa học không được vượt quá 255 ký tự',
            'ten_tieng_viet.required' => 'Tên tiếng Việt không được để trống',
            'ten_tieng_viet.max' => 'Tên tiếng Việt không được vượt quá 255 ký tự',
            'ten_tac_gia.max' => 'Tên tác giả không được vượt quá 255 ký tự',
            'dac_huu.max' => 'Đặc hữu không được vượt quá 50 ký tự',
            'sach_do.max' => 'Sách đỏ không được vượt quá 50 ký tự',
            'iucn.max' => 'IUCN không được vượt quá 50 ký tự',
            'nd_84.max' => 'NĐ 84 không được vượt quá 50 ký tự',
            'images.*.image' => 'File phải là hình ảnh',
            'images.*.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif, webp',
            'images.*.max' => 'Kích thước hình ảnh không được vượt quá 5MB'
        ]);

        try {
            $updated = $this->dongVatService->update($id, $request->all());

            if ($updated) {
                // Xử lý upload ảnh nếu có
                if ($request->hasFile('images')) {
                    $result = $this->dongVatService->addMultipleImages($id, $request->file('images'));
                    if (!$result['success']) {
                        throw new \Exception($result['error']);
                    }
                }

                if ($request->ajax()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Cập nhật động vật thành công!',
                        'redirect' => route('dong-vat.index')
                    ]);
                }

                return redirect()->route('dong-vat.index')
                    ->with('success', 'Cập nhật động vật thành công!');
            } else {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Động vật không tồn tại!'
                    ], 400);
                }

                return redirect()->back()
                    ->withInput()
                    ->with('err', 'Động vật không tồn tại!');
            }
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 400);
            }

            return redirect()->back()
                ->withInput()
                ->with('err', $e->getMessage());
        }
    }

    public function destroy(int $id): RedirectResponse
    {
        try {
            if ($this->dongVatService->isInUse($id)) {
                return redirect()->route('dong-vat.index')
                    ->with('err', 'Không thể xóa động vật này vì đang được sử dụng!');
            }

            $deleted = $this->dongVatService->delete($id);

            if ($deleted) {
                return redirect()->route('dong-vat.index')
                    ->with('success', 'Xóa động vật thành công!');
            } else {
                return redirect()->route('dong-vat.index')
                    ->with('err', 'Động vật không tồn tại!');
            }
        } catch (\Exception $e) {
            return redirect()->route('dong-vat.index')
                ->with('err', $e->getMessage());
        }
    }

    public function search(Request $request): View
    {
        $searchTerm = $request->get('search', '');
        $dongVats = collect();

        if (!empty($searchTerm)) {
            $dongVats = $this->dongVatService->searchByName($searchTerm);
        }

        return view('pages.dong-vat.index', compact('dongVats', 'searchTerm'));
    }

    /**
     * Upload hình ảnh cho động vật
     */
    public function uploadImage(Request $request, int $id): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB
        ], [
            'image.required' => 'Vui lòng chọn hình ảnh',
            'image.image' => 'File phải là hình ảnh',
            'image.mimes' => 'Chỉ chấp nhận định dạng: JPEG, PNG, JPG, GIF, WEBP',
            'image.max' => 'Kích thước file tối đa 5MB'
        ]);

        $result = $this->dongVatService->addImage($id, $request->file('image'));

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => 'Upload hình ảnh thành công!',
                'image' => $result['image'],
                'url' => $result['url'],
                'thumb_url' => $result['thumb_url']
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['error']
        ], 400);
    }

    /**
     * Upload hình ảnh từ file path
     */
    public function uploadImageFromPath(Request $request, int $id): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'file_path' => 'required|string',
        ], [
            'file_path.required' => 'Đường dẫn file không được để trống'
        ]);

        $result = $this->dongVatService->addImageFromPath($id, $request->input('file_path'));

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => 'Upload hình ảnh thành công!',
                'image' => $result['image'],
                'url' => $result['url'],
                'thumb_url' => $result['thumb_url']
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['error']
        ], 400);
    }

    /**
     * Xóa hình ảnh
     */
    public function deleteImage(int $imageId): \Illuminate\Http\JsonResponse
    {
        $result = $this->dongVatService->deleteImage($imageId);

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => 'Xóa hình ảnh thành công!'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['error']
        ], 400);
    }

    /**
     * Lấy danh sách hình ảnh
     */
    public function getImages(int $id): \Illuminate\Http\JsonResponse
    {
        $images = $this->dongVatService->getImages($id);

        return response()->json([
            'success' => true,
            'images' => $images
        ]);
    }
}
