<!-- Sex-Disaggregated Staff Data Section -->
@if(isset($staffTotalByGender) && ($staffTotalByGender['Male'] > 0 || $staffTotalByGender['Female'] > 0 || $staffTotalByGender['Other'] > 0))
    <section style="background: linear-gradient(135deg, #FF6B6B 0%, #C92A2A 100%); border-radius: 12px; padding: 3rem; color: white; margin: 3rem 0; box-shadow: 0 8px 24px rgba(255, 107, 107, 0.4);">
        
        <!-- Section Header -->
        <div style="margin-bottom: 2.5rem;">
            <h2 style="margin: 0 0 0.5rem 0; font-size: 2rem; display: flex; align-items: center; gap: 1rem;">
                <i class="fas fa-users" style="font-size: 2.2rem;"></i>
                Sex-Disaggregated Staff Data
            </h2>
            <p style="margin: 0.5rem 0 0 0; color: rgba(255, 255, 255, 0.9); font-size: 1.05rem;">
                University Staff Distribution by Gender
            </p>
        </div>

        <!-- Staff Summary Block -->
        <div style="background: rgba(255, 255, 255, 0.1); border-radius: 12px; padding: 2rem; margin-bottom: 2.5rem; backdrop-filter: blur(10px);">
            <h3 style="margin-top: 0; margin-bottom: 1.5rem; font-size: 1.4rem;">
                <i class="fas fa-chart-bar"></i> Staff Summary
            </h3>

            <!-- Summary Cards Grid -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
                <div style="background: #4C6EF5; border-radius: 8px; padding: 1.5rem; text-align: center;">
                    <p style="color: rgba(255, 255, 255, 0.8); font-size: 0.9rem; margin: 0 0 0.5rem 0;">Male Staff</p>
                    <h3 style="color: white; font-size: 2.5rem; margin: 0;">{{ $staffTotalByGender['Male'] ?? 0 }}</h3>
                    <p style="color: rgba(255, 255, 255, 0.8); font-size: 0.95rem; margin: 0.5rem 0 0 0;">
                        @php
                            $totalStaff = $staffTotalByGender['Male'] + $staffTotalByGender['Female'] + $staffTotalByGender['Other'];
                            $malePercentage = $totalStaff > 0 ? round(($staffTotalByGender['Male'] / $totalStaff) * 100, 1) : 0;
                        @endphp
                        {{ $malePercentage }}%
                    </p>
                </div>

                <div style="background: #FF922B; border-radius: 8px; padding: 1.5rem; text-align: center;">
                    <p style="color: rgba(255, 255, 255, 0.8); font-size: 0.9rem; margin: 0 0 0.5rem 0;">Female Staff</p>
                    <h3 style="color: white; font-size: 2.5rem; margin: 0;">{{ $staffTotalByGender['Female'] ?? 0 }}</h3>
                    <p style="color: rgba(255, 255, 255, 0.8); font-size: 0.95rem; margin: 0.5rem 0 0 0;">
                        @php
                            $femalePercentage = $totalStaff > 0 ? round(($staffTotalByGender['Female'] / $totalStaff) * 100, 1) : 0;
                        @endphp
                        {{ $femalePercentage }}%
                    </p>
                </div>

                <div style="background: rgba(255, 255, 255, 0.15); border-radius: 8px; padding: 1.5rem; text-align: center;">
                    <p style="color: rgba(255, 255, 255, 0.8); font-size: 0.9rem; margin: 0 0 0.5rem 0;">Other</p>
                    <h3 style="color: white; font-size: 2.5rem; margin: 0;">{{ $staffTotalByGender['Other'] ?? 0 }}</h3>
                    <p style="color: rgba(255, 255, 255, 0.8); font-size: 0.95rem; margin: 0.5rem 0 0 0;">
                        @php
                            $otherPercentage = $totalStaff > 0 ? round(($staffTotalByGender['Other'] / $totalStaff) * 100, 1) : 0;
                        @endphp
                        {{ $otherPercentage }}%
                    </p>
                </div>
            </div>

            <!-- Total Staff -->
            <div style="background: rgba(255, 255, 255, 0.08); border-left: 4px solid #FFD700; border-radius: 4px; padding: 1.5rem;">
                <p style="margin: 0; color: rgba(255, 255, 255, 0.95); font-size: 1.05rem; line-height: 1.6;">
                    <i class="fas fa-info-circle" style="margin-right: 0.5rem;"></i>
                    <strong>Total University Staff:</strong> {{ $totalStaff }} personnel
                </p>
            </div>
        </div>

        <!-- Staff by Office and Gender Table -->
        @if(isset($staffByOfficeAndGender) && count($staffByOfficeAndGender) > 0)
            <div style="background: rgba(255, 255, 255, 0.1); border-radius: 12px; padding: 2rem; backdrop-filter: blur(10px); overflow-x: auto;">
                <h3 style="margin-top: 0; margin-bottom: 1.5rem; font-size: 1.4rem;">
                    <i class="fas fa-building"></i> Staff by Office & Gender
                </h3>

                <table style="width: 100%; border-collapse: collapse; color: white;">
                    <thead>
                        <tr style="border-bottom: 2px solid rgba(255, 255, 255, 0.2);">
                            <th style="padding: 1rem; text-align: left; color: rgba(255, 255, 255, 0.9);">Office</th>
                            <th style="padding: 1rem; text-align: center; color: rgba(255, 255, 255, 0.9);">Male</th>
                            <th style="padding: 1rem; text-align: center; color: rgba(255, 255, 255, 0.9);">Female</th>
                            <th style="padding: 1rem; text-align: center; color: rgba(255, 255, 255, 0.9);">Other</th>
                            <th style="padding: 1rem; text-align: center; color: rgba(255, 255, 255, 0.9);">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($staffByOfficeAndGender as $office => $counts)
                            <tr style="border-bottom: 1px solid rgba(255, 255, 255, 0.1); transition: background-color 0.3s;">
                                <td style="padding: 1rem; text-align: left;">{{ $office }}</td>
                                <td style="padding: 1rem; text-align: center;">{{ $counts['Male'] }}</td>
                                <td style="padding: 1rem; text-align: center;">{{ $counts['Female'] }}</td>
                                <td style="padding: 1rem; text-align: center;">{{ $counts['Other'] }}</td>
                                <td style="padding: 1rem; text-align: center; font-weight: bold; background: rgba(255, 255, 255, 0.05);">{{ $counts['Total'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>
@endif
