<!-- Simplified Sex-Disaggregated Student Enrollment Data for Admin -->
<section style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px; padding: 2rem; color: white; margin-bottom: 2rem; box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);">
    <h4 style="margin-top: 0; margin-bottom: 1.5rem; font-size: 1.3rem;">
        <i class="fas fa-venus-mars"></i> Sex-Disaggregated Student Enrollment Data (2025-2026)
    </h4>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.5rem;">
        <div style="background: rgba(255, 255, 255, 0.15); border-radius: 8px; padding: 1.5rem; text-align: center; backdrop-filter: blur(10px);">
            <p style="color: rgba(255, 255, 255, 0.8); font-size: 0.9rem; margin-bottom: 0.5rem; margin-top: 0;">Total Students</p>
            <h3 style="color: #fff; font-size: 2rem; margin: 0;">{{ number_format($enrollmentStats['total_students']) }}</h3>
        </div>

        <div style="background: #5E72E4; border-radius: 8px; padding: 1.5rem; text-align: center;">
            <p style="color: rgba(255, 255, 255, 0.9); font-size: 0.9rem; margin-bottom: 0.5rem; margin-top: 0;">Male Students</p>
            <h3 style="color: #fff; font-size: 2rem; margin: 0;">{{ number_format($enrollmentStats['total_male']) }}</h3>
            <p style="margin: 0.5rem 0 0 0; color: rgba(255, 255, 255, 0.8); font-size: 0.85rem;">{{ round($enrollmentStats['male_percentage'], 2) }}%</p>
        </div>

        <div style="background: #B8BED4; border-radius: 8px; padding: 1.5rem; text-align: center;">
            <p style="color: rgba(0, 0, 0, 0.7); font-size: 0.9rem; margin-bottom: 0.5rem; margin-top: 0;">Female Students</p>
            <h3 style="color: #333; font-size: 2rem; margin: 0;">{{ number_format($enrollmentStats['total_female']) }}</h3>
            <p style="margin: 0.5rem 0 0 0; color: rgba(0, 0, 0, 0.6); font-size: 0.85rem;">{{ round($enrollmentStats['female_percentage'], 2) }}%</p>
        </div>

        <div style="background: rgba(255, 255, 255, 0.15); border-radius: 8px; padding: 1.5rem; text-align: center; backdrop-filter: blur(10px);">
            <p style="color: rgba(255, 255, 255, 0.8); font-size: 0.9rem; margin-bottom: 0.5rem; margin-top: 0;">Colleges</p>
            <h3 style="color: #fff; font-size: 2rem; margin: 0;">{{ $enrollmentStats['colleges_count'] }}</h3>
        </div>
    </div>
</section>
